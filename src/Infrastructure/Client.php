<?php
/**
 * Class Client
 *
 * @package Infrastructure
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */

namespace Bttw\Infrastructure;

use Bttw\Domain\Ball;
use Bttw\Domain\Basket\IBasket;
use Bttw\Infrastructure\Command\GetBaskets;
use Bttw\Infrastructure\Command\GetSolution;
use Bttw\Infrastructure\Exception\ClientException;
use Bttw\Infrastructure\Exception\ProtocolException;
use Bttw\Infrastructure\Message\Error;
use Bttw\Infrastructure\Command\PutBall;
use Bttw\Infrastructure\Message\Solution;
use Bttw\Infrastructure\Message\UniverseBaskets;
use Bttw\Infrastructure\Message\UserBasket;
use Ratchet\ConnectionInterface;

/**
 * Description of the class
 *
 * @package Infrastructure
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */
class Client
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var IBasket[]
     */
    private $universeBaskets;

    /**
     * @var IBasket
     */
    private $userBasket;

    /**
     * @var Controller
     */
    private $controller;

    /**
     * Client constructor.
     *
     * @param Controller          $controller
     * @param ConnectionInterface $connection
     * @param IBasket             $userBasket
     * @param array               $universeBaskets
     */
    public function __construct(
        Controller $controller,
        ConnectionInterface $connection,
        IBasket $userBasket,
        array $universeBaskets
    )
    {
        $this->controller = $controller;
        $this->connection = $connection;
        $this->userBasket = $userBasket;
        $this->universeBaskets = $universeBaskets;

        $this->sendUniverseBaskets();
        $this->sendUserBasket();
    }

    private function basketToArray(IBasket $basket)
    {
        return array_map(
            function (Ball $ball) {
                return $ball->getNumber();
            },
            iterator_to_array($basket, false)
        );
    }

    private function receiveGetSolution(GetSolution $command)
    {
        $wholeOwnedByUser = [];
        $oneOwnedByUser = [];
        foreach ($this->universeBaskets as $index => $basket) {
            $commonBallCount = $this->userBasket->countCommonBalls($basket);
            if ($commonBallCount === 1) {
                $oneOwnedByUser[] = $index;
            } elseif ($commonBallCount === $basket->count()) {
                $wholeOwnedByUser[] = $index;
            }
        }

        $this->connection->send(
            Protocol::formatMessage(
                new Solution($wholeOwnedByUser, $oneOwnedByUser)
            )
        );
    }

    private function receiveGetBaskets(GetBaskets $command)
    {
        $this->sendUniverseBaskets();
    }

    private function receivePutBall(PutBall $command)
    {
        $number = $command->getBall()->getNumber();
        if ($number > MAX_BALL_NUMBER || $number < 1) {
            $this->sendError('Wrong ball number given');
            $this->sendUserBasket();
            return;
        }

        try {
            $this->userBasket->putBall($command->getBall());
        } catch (\OverflowException $e) {
            $this->sendError('Your basket is full');
        } catch (\Exception $e) {
            $this->sendError('Error: ' . $e->getMessage());
        }
        $this->sendUserBasket();
    }

    private function sendUniverseBaskets()
    {
        $this->connection->send(
            Protocol::formatMessage(
                new UniverseBaskets(
                    array_map([$this, 'basketToArray'], $this->universeBaskets)
                )
            )
        );
    }

    private function sendUserBasket()
    {
        $this->connection->send(
            Protocol::formatMessage(
                new UserBasket(
                    $this->basketToArray($this->userBasket)
                )
            )
        );
    }

    private function sendError($error)
    {
        $this->connection->send(
            Protocol::formatMessage(
                new Error((string) $error)
            )
        );
    }

    public function receiveCommand($data)
    {
        try {
            $command = Protocol::parseCommand($data);
        } catch (ProtocolException $e) {
            $this->sendError($e);
            return;
        }

        if ($command instanceof GetBaskets) {
            $this->receiveGetBaskets($command);
        } elseif ($command instanceof GetSolution) {
            $this->receiveGetSolution($command);
        } elseif ($command instanceof PutBall) {
            $this->receivePutBall($command);
        } else {
            $this->sendError(new ClientException('Unknown command received'));
        }
    }
}