<?php
/**
 * Class Chat
 *
 * @package Infrastructure
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */

namespace Bttw\Infrastructure;

use Bttw\Domain\BasketFactory\AbstractBasketFactory;
use Bttw\Infrastructure\Client;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

/**
 * Description of the class
 *
 * @package Infrastructure
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */
class Controller implements MessageComponentInterface
{
    /**
     * @var \SplObjectStorage
     */
    private $clients;

    /**
     * @var AbstractBasketFactory
     */
    private $basketFactory;

    public function __construct(AbstractBasketFactory $basketFactory)
    {
        $this->clients = new \SplObjectStorage;
        $this->basketFactory = $basketFactory;
    }

    private function createNewClient(ConnectionInterface $connection)
    {
        $universeBaskets = [];
        for ($i = 0; $i < UNIVERSE_BASKET_COUNT; $i ++) {
            $universeBaskets[] = $this->basketFactory
                ->createFilled(UNIVERSE_BASKET_SIZE);
        }
        return new Client(
            $this,
            $connection,
            $this->basketFactory->create(USER_BASKET_SIZE),
            $universeBaskets
        );
    }

    public function onOpen(ConnectionInterface $connection)
    {
        echo "New connection! ({$connection->resourceId})\n";
        $this->clients->attach($connection, $this->createNewClient($connection));
    }

    public function onMessage(ConnectionInterface $from, $data)
    {
        echo sprintf('Connection %d sent command %s' . "\n", $from->resourceId, $data);
        $client = $this->clients[$from];
        /** @var Client $client */
        $client->receiveCommand($data);
    }

    public function onClose(ConnectionInterface $connection)
    {
        $this->clients->detach($connection);
        echo "Connection {$connection->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $connection, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $connection->close();
    }
}