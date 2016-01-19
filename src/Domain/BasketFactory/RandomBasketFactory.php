<?php
/**
 * Class BasketFactory
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

use Bttw\Domain\Ball;
use Bttw\Domain\Basket\IBasket;

/**
 * Basket factory. Fills
 *
 * @category Bttw
 * @package  Domain\BasketFactory
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class RandomBasketFactory extends AbstractBasketFactory
{
    /**
     * List of available ball numbers
     * @var int[]
     */
    private $_ballNumbersAvailable;

    /**
     * BasketFactory constructor.
     *
     * @param string $class         Basket class
     * @param int    $maxBallNumber Largest ball number
     */
    public function __construct($class, $maxBallNumber)
    {
        parent::__construct($class);
        $this->_ballNumbersAvailable = range(1, $maxBallNumber);
    }

    /**
     * Creates randomly filled basket
     *
     * @param int $size  Basket size
     * @param int $count Balls to create
     *
     * @return IBasket
     */
    public function createFilled($size, $count)
    {
        $basket = $this->create($size);
        $ballsToGenerate = min($count, $size);
        // partially used shuffling algorithm
        for ($i = 0; $i < $ballsToGenerate; ++$i) {
            $choiceIndex = mt_rand($i, count($this->_ballNumbersAvailable) - 1);
            $choice = $this->_ballNumbersAvailable[$choiceIndex];
            $this->_ballNumbersAvailable[$choiceIndex]
                = $this->_ballNumbersAvailable[$i];
            $this->_ballNumbersAvailable[$i] = $choice;
            $basket->putBall(new Ball($choice));
        }
        return $basket;
    }

    /**
     * Creates a basket filled with a random number of balls
     *
     * @param int $size     Basket size
     * @param int $minCount Min number of balls
     * @param int $maxCount Max number of balls
     *
     * @return IBasket
     */
    public function createFilledWithRandomCount($size, $minCount, $maxCount)
    {
        if ($minCount < 0) {
            throw new \InvalidArgumentException('minCount should be positive');
        }
        if ($maxCount < $minCount) {
            throw new \InvalidArgumentException(
                'maxCount should be greater than minCount'
            );
        }
        return $this->createFilled($size, mt_rand($minCount, $maxCount));
    }
}