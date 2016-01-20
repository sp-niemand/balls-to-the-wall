<?php
/**
 * Class Error
 *
 * @package Infrastructure\Message
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */

namespace Bttw\Infrastructure\Message;

/**
 * Description of the class
 *
 * @package Infrastructure\Message
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */
class Error extends Message
{
    private $message;

    /**
     * Error constructor.
     *
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    protected function jsonData()
    {
        return ['message' => $this->message];
    }
}