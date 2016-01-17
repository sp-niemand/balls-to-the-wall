<?php
/**
 * Class AbstractBasket
 *
 * @author Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @package domain
 */

namespace domain;

use bttw\domain\IBasket;

/**
 * Abstract basket class
 *
 * @author Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @package domain
 */
abstract class AbstractBasket implements IBasket
{
    /** @var int Basket size */
    private $size;

    /**
     * @param int $size Basket size
     */
    public function __construct($size)
    {
        if (! is_integer($size) || $size < 1) {
            throw new \InvalidArgumentException('Size must be a positive integer');
        }
        $this->size = $size;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
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
     * @param Ball $ball
     */
    public function putBall(Ball $ball)
    {
        if ($this->count() >= $this->size) {
            throw new \OverflowException('Can not add a ball, the basket is full');
        }
        $this->putBallInternal($ball);
    }

    /**
     * Actual ball adding code
     *
     * @param Ball $ball
     */
    abstract protected function putBallInternal(Ball $ball);

    /**
     * Checks if there is the ball given in the basket
     *
     * @param Ball $ball
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
        return $this->size;
    }
}