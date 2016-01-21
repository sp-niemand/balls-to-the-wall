<?php
/**
 * Class PutBall
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Infrastructure\Command
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Infrastructure\Command;

use Bttw\Domain\Ball;

/**
 * PutBall command
 *
 * @category Bttw
 * @package  Infrastructure\Command
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class PutBall extends Command
{
    /**
     * The ball
     *
     * @var Ball
     */
    private $_ball;

    /**
     * PutBall constructor.
     *
     * @param int $ballNumber Ball number
     */
    public function __construct($ballNumber)
    {
        $this->_ball = new Ball($ballNumber);
    }

    /**
     * Ball accessor
     *
     * @return Ball
     */
    public function getBall()
    {
        return $this->_ball;
    }
}