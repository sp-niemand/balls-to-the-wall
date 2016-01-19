<?php
/**
 * Class RandomBasketFactoryTest
 *
 * @package Domain\BasketFactory
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */

namespace Domain\BasketFactory;
use Bttw\Domain\Basket\HashMapBasket;
use Bttw\Domain\BasketFactory\RandomBasketFactory;

/**
 * Description of the class
 *
 * @package Domain\BasketFactory
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */
class RandomBasketFactoryTest extends \PHPUnit_Framework_TestCase
{
    private function getFactory()
    {
        return new RandomBasketFactory(HashMapBasket::class, 999);
    }

    public function testCreate()
    {
        $factory = $this->getFactory();
        $basket = $factory->create(666);
        $this->assertEquals(666, $basket->getSize());
        $this->assertInstanceOf(HashMapBasket::class, $basket);
    }

    public function testCreateFilled()
    {
        $factory = $this->getFactory();
        /** @type HashMapBasket $basket */
        $basket = $factory->createFilled(5, 2);
        $this->assertEquals(2, $basket->count());

        $tryCounter = 0;
        $tryLimit = 2;
        do {
            $basket1 = iterator_to_array($factory->createFilled(50, 10)->getIterator());
            $basket2 = iterator_to_array($factory->createFilled(50, 10)->getIterator());
        } while ($basket1 == $basket2 && ++$tryCounter < $tryLimit);
        if ($tryCounter >= $tryLimit) {
            $this->fail('bad random');
        }
    }

    private function assertBetween($expected, $actual)
    {
        $this->assertGreaterThanOrEqual($expected[0], $actual);
        $this->assertLessThanOrEqual($expected[1], $actual);
    }

    public function testCreateFilledWithRandomCount()
    {
        $factory = $this->getFactory();

        for ($i=0; $i<50; ++$i) {
            $basket = $factory->createFilledWithRandomCount(20, 4, 14);
            $this->assertBetween([4, 14], $basket->count());
        }
    }
}