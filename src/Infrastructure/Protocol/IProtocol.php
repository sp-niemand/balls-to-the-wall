<?php
/**
 * Interface IProtocol
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Infrastructure\Protocol
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Infrastructure\Protocol;
use Bttw\Infrastructure\Command\Command;
use Bttw\Infrastructure\Exception\ProtocolException;
use Bttw\Infrastructure\Message\Message;

/**
 * Protocol interface
 *
 * @category Bttw
 * @package  Infrastructure\Protocol
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
interface IProtocol
{
    /**
     * Parses the command from string
     *
     * @param string $commandString Raw command string
     *
     * @return Command
     * @throws ProtocolException If parsing fails
     */
    public function parseCommand($commandString);

    /**
     * Formats the message to string
     *
     * @param Message $message Message
     *
     * @return string
     */
    public function formatMessage(Message $message);
}