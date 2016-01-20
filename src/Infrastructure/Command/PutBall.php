<?php
/**
 * Class PutBall
 *
 * @package Infrastructure\Command
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */

namespace Bttw\Infrastructure\Command;
use Bttw\Domain\Ball;

/**
 * Description of the class
 *
 * @package Infrastructure\Command
 * @author  Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 */
class PutBall extends Command
{
    /**
     * @var Ball
     */
    private $ball;

    public function __construct($ballNumber)
    {
        $this->ball = new Ball($ballNumber);
    }

    /**
     * @return Ball
     */
    public function getBall()
    {
        return $this->ball;
    }
}