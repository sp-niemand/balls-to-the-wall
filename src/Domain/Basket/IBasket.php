<?php
/**
 * Interface IBasket
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
 * Basket interface
 *
 * @category Bttw
 * @package  Domain
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
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
     * @param IBasket $other The other basket
     *
     * @return int
     */
    public function countCommonBalls(IBasket $other);

    /**
     * Puts ball into the basket
     *
     * @param Ball $ball The ball
     *
     * @return void
     * @throws \OverflowException If the basket is already full
     */
    public function putBall(Ball $ball);

    /**
     * Checks if there is the ball given in the basket
     *
     * @param Ball $ball The ball
     *
     * @return bool
     */
    public function hasBall(Ball $ball);
}