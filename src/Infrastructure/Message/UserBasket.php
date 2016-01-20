<?php
/**
 * Class UserBasket
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
class UserBasket extends Message
{
    private $basket;

    public function __construct($basket)
    {
        $this->basket = $basket;
    }

    public function getBaskets()
    {
        return $this->basket;
    }

    protected function jsonData()
    {
        return ['basket' => $this->basket];
    }
}