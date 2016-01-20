<?php
/**
 * Class Protocol
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Infrastructure\Protocol
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Infrastructure\Protocol;

use Bttw\Infrastructure\Command\Command;
use Bttw\Infrastructure\Command\GetBaskets;
use Bttw\Infrastructure\Command\GetSolution;
use Bttw\Infrastructure\Command\PutBall;
use Bttw\Infrastructure\Exception\ProtocolException;
use Bttw\Infrastructure\Message\Message;

/**
 * Json protocol implementation
 *
 * @category Bttw
 * @package  Infrastructure\Protocol
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class JsonProtocol implements IProtocol
{
    /**
     * Parses the command from string
     *
     * @param string $commandString Raw command string
     *
     * @return Command
     * @throws ProtocolException If parsing fails
     */
    public function parseCommand($commandString)
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
            if (!isset($data['ballNumber'])) {
                throw new ProtocolException('Ball number not given');
            }
            return new PutBall($data['ballNumber']);
        default:
            throw new ProtocolException('Unknown command type given');
        }
    }

    /**
     * Formats the message to string
     *
     * @param Message $message Message
     *
     * @return string
     */
    public function formatMessage(Message $message)
    {
        return json_encode($message);
    }
}