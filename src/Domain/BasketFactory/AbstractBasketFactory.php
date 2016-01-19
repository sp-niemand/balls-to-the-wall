<?php
/**
 * Class AbstractBasketFactory
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Domain\BasketFactory
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Domain\BasketFactory;

use Bttw\Domain\Basket\AbstractBasket;
use Bttw\Domain\Basket\IBasket;

/**
 * Abstract basket factory
 *
 * @category Bttw
 * @package  Domain\BasketFactory
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
abstract class AbstractBasketFactory
{
    /**
     * Basket class
     * @var string
     */
    private $_class;

    /**
     * BasketFactory constructor.
     *
     * @param string $class Basket class
     */
    public function __construct($class)
    {
        $this->_setClass($class);
    }

    /**
     * Class mutator
     *
     * @param string $class Class name
     *
     * @return void
     * @throws \InvalidArgumentException If wrong class is given
     */
    private function _setClass($class)
    {
        if (!in_array(IBasket::class, class_implements($class))) {
            throw new \InvalidArgumentException('Class must implement IBasket');
        }
        $this->_class = $class;
    }

    /**
     * Class accessor
     *
     * @return string
     */
    protected function getClass()
    {
        return $this->_class;
    }

    /**
     * Creates empty basket
     *
     * @param int $size Basket size
     *
     * @return AbstractBasket
     */
    public function create($size)
    {
        $class = $this->getClass();
        return (new $class($size));
    }

    /**
     * Creates a basket filled with balls
     *
     * @param int $size  Basket size
     * @param int $count Balls to create
     *
     * @return AbstractBasket
     */
    abstract public function createFilled($size, $count);
}