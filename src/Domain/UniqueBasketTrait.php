<?php
/**
 * Trait UniqueBasketTrait
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Domain
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Domain;

/**
 * Unique basket trait
 *
 * @category Bttw
 * @package  Domain
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
trait UniqueBasketTrait
{
    /**
     * Checks if there is the ball given in the basket
     *
     * @param Ball $ball The ball
     *
     * @return bool
     */
    abstract public function hasBall(Ball $ball);

    /**
     * Puts ball into the basket
     *
     * @param Ball $ball The ball
     *
     * @return void
     */
    public function putBall(Ball $ball)
    {
        if ($this->hasBall($ball)) {
            throw new \InvalidArgumentException('Only unique balls can be added');
        }
        parent::putBall($ball);
    }

    /**
     * Counts the balls common to this and other basket
     *
     * @param IBasket $other The other basket
     *
     * @return int
     */
    public function countCommonBalls(IBasket $other)
    {
        $result = 0;
        foreach ($other as $ball) {
            if ($this->hasBall($ball)) {
                ++ $result;
            }
        }
        return $result;
    }
}