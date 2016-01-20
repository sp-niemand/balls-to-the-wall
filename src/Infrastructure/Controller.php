<?php
/**
 * Class Chat
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Infrastructure
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Infrastructure;

use Bttw\Domain\BasketFactory\AbstractBasketFactory;
use Bttw\Infrastructure\Protocol\JsonProtocol;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

/**
 * Connection controller
 *
 * @category Bttw
 * @package  Infrastructure
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class Controller implements MessageComponentInterface
{
    /**
     * Client sessions storage
     *
     * @var \SplObjectStorage
     */
    private $_clients;

    /**
     * Basket factory
     *
     * @var AbstractBasketFactory
     */
    private $_basketFactory;

    /**
     * Controller constructor.
     *
     * @param AbstractBasketFactory $basketFactory Basket factory
     */
    public function __construct(AbstractBasketFactory $basketFactory)
    {
        $this->_clients = new \SplObjectStorage;
        $this->_basketFactory = $basketFactory;
    }

    /**
     * Creates new client session instance for connection
     *
     * @param ConnectionInterface $connection Connection instance
     *
     * @return Client
     */
    private function _createNewClient(ConnectionInterface $connection)
    {
        $universeBaskets = [];
        for ($i = 0; $i < UNIVERSE_BASKET_COUNT; $i++) {
            $universeBaskets[] = $this->_basketFactory
                ->createFilled(UNIVERSE_BASKET_SIZE);
        }
        return new Client(
            $this,
            $connection,
            new JsonProtocol(),
            $this->_basketFactory->create(USER_BASKET_SIZE),
            $universeBaskets
        );
    }

    /**
     * 'open' handler
     *
     * @param ConnectionInterface $connection Connection instance
     *
     * @return void
     */
    public function onOpen(ConnectionInterface $connection)
    {
        $connHash = spl_object_hash($connection);
        echo "New connection! ($connHash)\n";
        $this->_clients->attach($connection, $this->_createNewClient($connection));
    }

    /**
     * 'message' handler
     *
     * @param ConnectionInterface $from Message sender
     * @param string              $data Raw message data
     *
     * @return void
     */
    public function onMessage(ConnectionInterface $from, $data)
    {
        $connHash = spl_object_hash($from);
        echo sprintf(
            'Connection %d sent command %s' . "\n", $connHash, $data
        );
        $client = $this->_clients[$from];
        /**
         * Client instance
         *
         * @var Client $client
         */
        $client->receiveCommand($data);
    }

    /**
     * 'close' handler
     *
     * @param ConnectionInterface $connection Connection instance
     *
     * @return void
     */
    public function onClose(ConnectionInterface $connection)
    {
        $this->_clients->detach($connection);
        $connHash = spl_object_hash($connection);
        echo "Connection {$connHash} has disconnected\n";
    }

    /**
     * 'error' handler
     *
     * @param ConnectionInterface $connection Connection instance
     * @param \Exception          $e          Exception
     *
     * @return void
     */
    public function onError(ConnectionInterface $connection, \Exception $e)
    {
        $connHash = spl_object_hash($connection);
        echo "An error on connection {$connHash} has occurred: {$e->getMessage()}\n";
        $connection->close();
    }
}