<?php
/**
 * Class Client
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Infrastructure
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Infrastructure;

use Bttw\Domain\Ball;
use Bttw\Domain\Basket\IBasket;
use Bttw\Infrastructure\Command\GetBaskets;
use Bttw\Infrastructure\Command\GetSolution;
use Bttw\Infrastructure\Command\PutBall;
use Bttw\Infrastructure\Exception\ClientException;
use Bttw\Infrastructure\Exception\ProtocolException;
use Bttw\Infrastructure\Message\Error;
use Bttw\Infrastructure\Message\Solution;
use Bttw\Infrastructure\Message\UniverseBaskets;
use Bttw\Infrastructure\Message\UserBasket;
use Bttw\Infrastructure\Protocol\IProtocol;
use Ratchet\ConnectionInterface;

/**
 * Application client
 *
 * Represents session on server. One gets created for every connection.
 *
 * @category Bttw
 * @package  Infrastructure
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class Client
{
    /**
     * Connection instance
     *
     * @var ConnectionInterface
     */
    private $_connection;

    /**
     * Universe's baskets
     *
     * @var IBasket[]
     */
    private $_universeBaskets;

    /**
     * User's basket
     *
     * @var IBasket
     */
    private $_userBasket;

    /**
     * WebSocket controller
     *
     * @var Controller
     */
    private $_controller;

    /**
     * Protocol instance
     *
     * @var IProtocol
     */
    private $_protocol;

    /**
     * Client constructor.
     *
     * @param Controller          $controller      Controller instance
     * @param ConnectionInterface $connection      Connection instance
     * @param IProtocol           $protocol        Protocol instance
     * @param IBasket             $userBasket      User's basket
     * @param array               $universeBaskets Universe's baskets
     */
    public function __construct(
        Controller $controller,
        ConnectionInterface $connection,
        IProtocol $protocol,
        IBasket $userBasket,
        array $universeBaskets
    ) {
        $this->_controller = $controller;
        $this->_connection = $connection;
        $this->_protocol = $protocol;
        $this->_userBasket = $userBasket;
        $this->_universeBaskets = $universeBaskets;

        $this->_sendUniverseBaskets();
        $this->_sendUserBasket();
    }

    /**
     * Creates array with ball numbers from the basket
     *
     * @param IBasket $basket Basket
     *
     * @return array
     */
    private function _basketToArray(IBasket $basket)
    {
        return array_map(
            function (Ball $ball) {
                return $ball->getNumber();
            },
            iterator_to_array($basket, false)
        );
    }

    /**
     * GetSolution command receiver
     *
     * @return void
     */
    private function _receiveGetSolution()
    {
        $wholeOwnedByUser = [];
        $oneOwnedByUser = [];
        foreach ($this->_universeBaskets as $index => $basket) {
            $commonBallCount = $this->_userBasket->countCommonBalls($basket);
            if ($commonBallCount === 1) {
                $oneOwnedByUser[] = $index;
            }
            if ($commonBallCount === $basket->count()) {
                $wholeOwnedByUser[] = $index;
            }
        }

        $this->_connection->send(
            $this->_protocol->formatMessage(
                new Solution($wholeOwnedByUser, $oneOwnedByUser)
            )
        );
    }

    /**
     * GetBaskets command receiver
     *
     * @return void
     */
    private function _receiveGetBaskets()
    {
        $this->_sendUniverseBaskets();
    }

    /**
     * PutBall command receiver
     *
     * @param PutBall $command Command
     *
     * @return void
     */
    private function _receivePutBall(PutBall $command)
    {
        $number = $command->getBall()->getNumber();
        if ($number > MAX_BALL_NUMBER || $number < 1) {
            $this->_sendError('Wrong ball number given');
            $this->_sendUserBasket();
            return;
        }

        try {
            $this->_userBasket->putBall($command->getBall());
        } catch (\OverflowException $e) {
            $this->_sendError('Your basket is full');
        } catch (\Exception $e) {
            $this->_sendError('Error: ' . $e->getMessage());
        }
        $this->_sendUserBasket();
    }

    /**
     * UniverseBaskets message sender
     *
     * @return void
     */
    private function _sendUniverseBaskets()
    {
        $this->_connection->send(
            $this->_protocol->formatMessage(
                new UniverseBaskets(
                    array_map([$this, '_basketToArray'], $this->_universeBaskets)
                )
            )
        );
    }

    /**
     * UserBasket message sender
     *
     * @return void
     */
    private function _sendUserBasket()
    {
        $this->_connection->send(
            $this->_protocol->formatMessage(
                new UserBasket(
                    $this->_basketToArray($this->_userBasket)
                )
            )
        );
    }

    /**
     * Error message sender
     *
     * @param string $error Message
     *
     * @return void
     */
    private function _sendError($error)
    {
        $this->_connection->send(
            $this->_protocol->formatMessage(
                new Error((string)$error)
            )
        );
    }

    /**
     * Data receiver
     *
     * @param string $data Raw data
     *
     * @return void
     */
    public function receiveCommand($data)
    {
        try {
            $command = $this->_protocol->parseCommand($data);
        } catch (ProtocolException $e) {
            $this->_sendError($e);
            return;
        }

        if ($command instanceof GetBaskets) {
            $this->_receiveGetBaskets();
            return;
        } elseif ($command instanceof GetSolution) {
            $this->_receiveGetSolution();
            return;
        } elseif ($command instanceof PutBall) {
            $this->_receivePutBall($command);
            return;
        }
        $this->_sendError(new ClientException('Unknown command received'));
    }
}