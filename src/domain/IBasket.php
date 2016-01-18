<?php
/**
 * Interface IBasket
 *
 * @author Dmitri Cherepovski <codernumber1@gmail.com>
 * @package bttw\domain
 */

namespace bttw\domain;

/**
 * Basket interface
 *
 * @author Dmitri Cherepovski <codernumber1@gmail.com>
 * @package bttw\domain
 */
interface IBasket extends \IteratorAggregate, \Countable
{
    /**
     * Returns basket size (in balls)
     *
     * @return int
     */
    public function getSize();

    /**
     * Counts the balls common to this and other basket
     *
     * @param IBasket $other
     *
     * @return int
     */
    public function countCommonBalls(IBasket $other);

    /**
     * Puts ball into the basket
     *
     * @param Ball $ball
     */
    public function putBall(Ball $ball);

    /**
     * Checks if there is the ball given in the basket
     *
     * @param Ball $ball
     *
     * @return bool
     */
    public function hasBall(Ball $ball);
}