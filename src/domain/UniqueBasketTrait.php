<?php
/**
 * Trait UniqueBasketTrait
 *
 * @author Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @package domain
 */

namespace bttw\domain;

/**
 * Description of the trait
 *
 * @author Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @package domain
 */
trait UniqueBasketTrait
{
    /**
     * Puts ball into the basket
     *
     * @param Ball $ball
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
     * Naive implementation (n^2)
     *
     * @param IBasket $other
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