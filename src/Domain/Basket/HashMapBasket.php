<?php
/**
 * Class HashMapBasket
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Domain
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Domain\Basket;
use Bttw\Domain\Ball;
use Traversable;

/**
 * Description of the class
 *
 * @category Bttw
 * @package  Domain
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class HashMapBasket extends AbstractBasket
{
    use \Bttw\Domain\Basket\UniqueBasketTrait;

    /**
     * Hash map used to hold balls info
     * @var array
     */
    private $_ballNumbersHashMap = [];

    /**
     * Ball counter
     * @var int
     */
    private $_count = 0;

    /**
     * Checks if there is the ball given in the basket
     *
     * @param Ball $ball The ball to check
     *
     * @return bool
     */
    public function hasBall(Ball $ball)
    {
        return isset($this->_ballNumbersHashMap[$ball->getNumber()]);
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
        return $this->_count;
    }

    /**
     * Actual ball adding code
     *
     * @param Ball $ball The ball
     *
     * @return void
     */
    protected function putBallInternal(Ball $ball)
    {
        $this->_ballNumbersHashMap[$ball->getNumber()] = true;
        ++ $this->_count;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        foreach ($this->_ballNumbersHashMap as $ballNumber => $v) {
            yield new Ball($ballNumber);
        }
    }
}