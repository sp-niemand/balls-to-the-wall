<?php
/**
 * Class Ball
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
 * Ball class
 *
 * @category Bttw
 * @package  Domain
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class Ball
{
    /**
     * Ball number
     *
     * @var int
     */
    private $_number;

    /**
     * Ball constructor.
     *
     * @param int $number The ball number
     */
    public function __construct($number)
    {
        $this->_number = $number;
    }

    /**
     * Ball number accessor
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->_number;
    }
}