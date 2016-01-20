<?php
/**
 * Class Solution
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
class Solution extends Message
{
    /**
     * @var int[]
     */
    private $wholeOwnedByUser;

    /**
     * @var int[]
     */
    private $oneOwnedByUser;

    /**
     * Solution constructor.
     *
     * @param int[] $wholeOwnedByUser
     * @param int[] $oneOwnedByUser
     */
    public function __construct(array $wholeOwnedByUser, array $oneOwnedByUser)
    {
        $this->wholeOwnedByUser = $wholeOwnedByUser;
        $this->oneOwnedByUser = $oneOwnedByUser;
    }

    /**
     * @return mixed
     */
    public function getWholeOwnedByUser()
    {
        return $this->wholeOwnedByUser;
    }

    /**
     * @return mixed
     */
    public function getOneOwnedByUser()
    {
        return $this->oneOwnedByUser;
    }

    protected function jsonData()
    {
        return [
            'wholeOwnedByUser' => $this->wholeOwnedByUser,
            'oneOwnedByUser' => $this->oneOwnedByUser,
        ];
    }
}