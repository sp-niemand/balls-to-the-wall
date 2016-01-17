<?php
/**
 * Class HashMapBasket
 *
 * @author Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @package domain
 */

namespace domain;
use Traversable;

/**
 * Description of the class
 *
 * @author Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @package domain
 */
class HashMapBasket extends AbstractBasket
{
    use UniqueBasketTrait;

    /** @var array Hash map used to hold balls info */
    private $ballNumbersHashMap = [];

    /** @var int */
    private $count = 0;

    /**
     * Checks if there is the ball given in the basket
     *
     * @param Ball $ball
     *
     * @return bool
     */
    public function hasBall(Ball $ball)
    {
        return isset($this->ballNumbersHashMap[$ball->getNumber()]);
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
        return $this->count;
    }

    /**
     * @inheritdoc
     */
    protected function putBallInternal(Ball $ball)
    {
        $this->ballNumbersHashMap[$ball->getNumber()] = true;
        ++ $this->count;
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
        foreach ($this->ballNumbersHashMap as $ballNumber => $v) {
            yield new Ball($ballNumber);
        }
    }
}