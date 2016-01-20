<?php
/**
 * Class UserBasket
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Infrastructure\Message
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Infrastructure\Message;

/**
 * UserBasket message
 *
 * @category Bttw
 * @package  Infrastructure\Message
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class UserBasket extends Message
{
    /**
     * Numbers of balls in the basket
     * @var int[]
     */
    private $_basket;

    /**
     * UserBasket constructor.
     *
     * @param int[] $basket Basket
     */
    public function __construct($basket)
    {
        $this->_basket = $basket;
    }

    /**
     * Accessor
     *
     * @return \int[]
     */
    public function getBaskets()
    {
        return $this->_basket;
    }

    /**
     * Returns additional data for JSON encoding of this class instances
     *
     * @return array
     */
    protected function jsonData()
    {
        return ['basket' => $this->_basket];
    }
}