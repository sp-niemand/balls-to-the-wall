#!/usr/bin/php
<?php
/**
 * Entry point
 */
require dirname(__DIR__) . '/vendor/autoload.php';

// APP CONFIG
define('PORT', 8000);
define('IP', '127.0.0.1');

define('USER_BASKET_SIZE', 100);
define('UNIVERSE_BASKET_SIZE', 10);
define('UNIVERSE_BASKET_COUNT', 30);
define('MAX_BALL_NUMBER', 999);

// Your shell script
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;

$basketFactory = new \Bttw\Domain\BasketFactory\RandomBasketFactory(
    \Bttw\Domain\Basket\HashMapBasket::class, MAX_BALL_NUMBER
);
$ws = new WsServer(new \Bttw\Infrastructure\Controller($basketFactory));
$ws->disableVersion(0); // old, bad, protocol version

// Make sure you're running this as root
echo sprintf('Started websocket server on %s:%d' . "\n", IP, PORT);
$server = IoServer::factory(new HttpServer($ws), PORT, IP);
$server->run();