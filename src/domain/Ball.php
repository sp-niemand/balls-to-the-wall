<?php
/**
 * Class Ball
 *
 * @author Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @package domain
 */

namespace bttw\domain;

/**
 * Ball class
 *
 * @author Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @package domain
 */
class Ball
{
    private $number;

    public function __construct($number)
    {
        $this->number = $number;
    }

    public function getNumber()
    {
        return $this->number;
    }

    function __toString()
    {
        return 'Ball(' . $this->number . ')';
    }
}