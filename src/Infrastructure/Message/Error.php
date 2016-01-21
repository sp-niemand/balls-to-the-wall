<?php
/**
 * Class Error
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Infrastructure\Message
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Infrastructure\Message;

/**
 * Error message
 *
 * @category Bttw
 * @package  Infrastructure\Message
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class Error extends Message
{
    /**
     * Error message
     *
     * @var string
     */
    private $_message;

    /**
     * Error constructor.
     *
     * @param string $message Error message
     */
    public function __construct($message)
    {
        $this->_message = $message;
    }

    /**
     * Message accessor
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * Returns data for JSON encoding of this class instances
     *
     * @return array
     */
    protected function jsonData()
    {
        return ['message' => $this->_message];
    }
}