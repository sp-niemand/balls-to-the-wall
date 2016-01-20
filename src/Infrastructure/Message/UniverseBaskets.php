<?php
/**
 * Class UniverseBaskets
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Infrastructure\Message
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Infrastructure\Message;

/**
 * UniverseBaskets message
 *
 * @category Bttw
 * @package  Infrastructure\Message
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class UniverseBaskets extends Message
{
    /**
     * Universe baskets
     * @var array[]
     */
    private $_baskets;

    /**
     * UniverseBaskets constructor.
     *
     * @param array[] $baskets Universe baskets
     */
    public function __construct($baskets)
    {
        $this->_baskets = $baskets;
    }

    /**
     * Accessor
     *
     * @return \array[]
     */
    public function getBaskets()
    {
        return $this->_baskets;
    }

    /**
     * Returns additional data for JSON encoding of this class instances
     *
     * @return array
     */
    protected function jsonData()
    {
        return ['baskets' => $this->_baskets];
    }
}