<?php
/**
 * Class HashMapBasketTest
 *
 * @author Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */

namespace Test\Domain;
use Bttw\Domain\HashMapBasket;
use Bttw\Domain\Ball;

/**
 * HashMapBasket test
 *
 * @author Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */
class HashMapBasketTest extends \PHPUnit_Framework_TestCase
{
    private function createBasket(array $ballNumbers, $size = null)
    {
        if ($size === null) {
            $size = count($ballNumbers);
        }
        $result = new HashMapBasket($size);
        foreach ($ballNumbers as $ballNumber) {
            $result->putBall(new Ball($ballNumber));
        }
        return $result;
    }

    private function putBalls(HashMapBasket $basket, array $numbers)
    {
        foreach ($numbers as $number) {
            $basket->putBall(new Ball($number));
        }
    }

    public function testConstruction()
    {
        $basket = $this->createBasket([], 5);
        $this->assertCount(0, $basket);
        $this->assertEmpty(iterator_to_array($basket));
    }

    public function testPutBall()
    {
        $basket = $this->createBasket([1, 2], 3);

        $this->assertContains(new Ball(1), $basket, '', false, false);
        $this->assertContains(new Ball(2), $basket, '', false, false);

        try {
            $basket->putBall(new Ball(1));
            $this->fail();
        } catch (\InvalidArgumentException $e) {
        }

        $basket->putBall(new Ball(3));
        try {
            $basket->putBall(new Ball(4));
            $this->fail();
        } catch (\OverflowException $e) {
        }
    }

    public function testHasBall()
    {
        $basket = $this->createBasket([1, 666, 3]);
        $this->assertTrue($basket->hasBall(new Ball(666)));
        $this->assertFalse($basket->hasBall(new Ball(2)));
    }

    public function testCount()
    {
        $basket = $this->createBasket([], 3);
        $this->assertEquals(0, $basket->count()) ;

        $this->putBalls($basket, [5, 7]);
        $this->assertEquals(2, $basket->count());
    }

    public function testGetIterator()
    {
        $basket = $this->createBasket([1, 2], 3);

        $balls = iterator_to_array($basket);
        $this->assertContains(new Ball(1), $balls, '', false, false);
        $this->assertContains(new Ball(2), $balls, '', false, false);
        $this->assertEquals(2, count($balls));
    }

    public function testGetSize()
    {
        $basket = $this->createBasket([], 5);
        $this->assertEquals(5, $basket->getSize());
    }

    public function testCountCommonBalls()
    {
        $basket1 = $this->createBasket([], 5);
        $basket2 = $this->createBasket([], 5);
        $this->assertEquals(0, $basket1->countCommonBalls($basket2));

        $this->putBalls($basket1, [1, 2, 3]);
        $this->putBalls($basket2, [3, 4, 5]);
        $this->assertEquals(1, $basket1->countCommonBalls($basket2));

        $basket1 = $this->createBasket([1, 2, 3, 4, 5, 6, 7, 8], 8);
        $basket2 = $this->createBasket([5, 3, 4, 2, 1], 5);
        $this->assertEquals(5, $basket1->countCommonBalls($basket2));
    }
}