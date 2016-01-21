<?php
/**
 * Class BasketFactory
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Domain\BasketFactory
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Domain\BasketFactory;

use Bttw\Domain\Ball;
use Bttw\Domain\Basket\IBasket;

/**
 * Random basket factory
 *
 * Needs an array with length equal to a maximum possible number on a ball.
 * Obviously bad for large max ball numbers, but is deterministic
 * in time consumed.
 *
 * @category Bttw
 * @package  Domain\BasketFactory
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class RandomBasketFactory extends AbstractBasketFactory
{
    /**
     * List of available ball numbers
     *
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
     * @param int      $size  Basket size
     * @param int|null $count Balls to create. Random number of balls if null
     *
     * @return IBasket
     */
    public function createFilled($size, $count = null)
    {
        $ballsToGenerate = $this->getBallsToGenerateCount($size, $count);
        $basket = $this->create($size);
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
}