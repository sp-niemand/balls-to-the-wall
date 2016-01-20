<?php
/**
 * Class UniverseBaskets
 *
 * @package Infrastructure\Message
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */

namespace Bttw\Infrastructure\Message;

/**
 * Description of the class
 *
 * @package Infrastructure\Message
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */
class UniverseBaskets extends Message
{
    private $baskets;

    public function __construct($baskets)
    {
        $this->baskets = $baskets;
    }

    public function getBaskets()
    {
        return $this->baskets;
    }

    protected function jsonData()
    {
        return ['baskets' => $this->baskets];
    }
}