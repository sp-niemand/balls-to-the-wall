<?php
/**
 * Class Protocol
 *
 * @package Infrastructure
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */

namespace Bttw\Infrastructure;

use Bttw\Infrastructure\Command\GetBaskets;
use Bttw\Infrastructure\Command\GetSolution;
use Bttw\Infrastructure\Exception\ProtocolException;
use Bttw\Infrastructure\Message\Message;
use Bttw\Infrastructure\Command\PutBall;

/**
 * Description of the class
 *
 * @package Infrastructure
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */
class Protocol
{
    public static function parseCommand($commandString)
    {
        $data = json_decode($commandString, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ProtocolException(
                'Json decode fail: ' . json_last_error_msg()
            );
        }
        if (!is_array($data)) {
            throw new ProtocolException('Command data is not an array');
        }
        if (!isset($data['type']) || !$data['type']) {
            throw new ProtocolException('Command type not given');
        }

        $class = 'Bttw\\Infrastructure\\Command\\' . $data['type'];
        if (!class_exists($class)) {
            throw new ProtocolException('Command class does not exist');
        }

        switch ($class) {
        case GetBaskets::class:
            return new GetBaskets();
        case GetSolution::class:
            return new GetSolution();
        case PutBall::class:
            if (! isset($data['ballNumber'])) {
                throw new ProtocolException('Ball number not given');
            }
            return new PutBall($data['ballNumber']);
        default:
            throw new ProtocolException('Unknown command type given');
        }
    }

    public static function formatMessage(Message $message)
    {
        return json_encode($message);
    }
}