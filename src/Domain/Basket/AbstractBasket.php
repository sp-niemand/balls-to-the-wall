<?php
/**
 * Class AbstractBasket
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Domain
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Domain\Basket;
use Bttw\Domain\Ball;

/**
 * Abstract basket class
 *
 * @category Bttw
 * @package  Domain
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
abstract class AbstractBasket implements IBasket
{
    /**
     * Basket size
     *
     * @var int
     */
    private $_size;

    /**
     * Basket size
     *
     * @param int $size The size
     */
    public function __construct($size)
    {
        if (!is_integer($size) || $size < 1) {
            throw new \InvalidArgumentException('Size must be a positive integer');
        }
        $this->_size = $size;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     *
     * @link   http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return iterator_count($this);
    }

    /**
     * Puts ball into the basket
     *
     * @param Ball $ball The ball
     *
     * @return void
     * @throws \OverflowException If the basket is already full
     */
    public function putBall(Ball $ball)
    {
        if ($this->count() >= $this->_size) {
            throw new \OverflowException('Can not add a ball, the basket is full');
        }
        $this->putBallInternal($ball);
    }

    /**
     * Actual ball adding code
     *
     * @param Ball $ball The ball
     *
     * @return void
     */
    abstract protected function putBallInternal(Ball $ball);

    /**
     * Checks if there is the ball given in the basket
     *
     * @param Ball $ball The ball
     *
     * @return bool
     */
    public function hasBall(Ball $ball)
    {
        foreach ($this as $b) {
            if ($ball == $b) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns basket size (in balls)
     *
     * @return int
     */
    public function getSize()
    {
        return $this->_size;
    }
}