<?php
/**
 * Class Solution
 *
 * PHP version 5.5
 *
 * @category Bttw
 * @package  Infrastructure\Message
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */

namespace Bttw\Infrastructure\Message;

/**
 * Solution message
 *
 * @category Bttw
 * @package  Infrastructure\Message
 * @author   Dmitri Cherepovski <codernumber1@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
class Solution extends Message
{
    /**
     * Numbers of baskets, where balls are fully owned by the user
     *
     * @var int[]
     */
    private $_wholeOwnedByUser;

    /**
     * Numbers of baskets, where exactly one ball is owned by the user
     *
     * @var int[]
     */
    private $_oneOwnedByUser;

    /**
     * Solution constructor.
     *
     * @param int[] $wholeOwnedByUser Baskets fully owned
     * @param int[] $oneOwnedByUser   Baskets with exactly one ball owned
     */
    public function __construct(array $wholeOwnedByUser, array $oneOwnedByUser)
    {
        $this->_wholeOwnedByUser = $wholeOwnedByUser;
        $this->_oneOwnedByUser = $oneOwnedByUser;
    }

    /**
     * Accessor
     *
     * @return int[]
     */
    public function getWholeOwnedByUser()
    {
        return $this->_wholeOwnedByUser;
    }

    /**
     * Accessor
     *
     * @return int[]
     */
    public function getOneOwnedByUser()
    {
        return $this->_oneOwnedByUser;
    }

    /**
     * Returns additional data for JSON encoding of this class instances
     *
     * @return array
     */
    protected function jsonData()
    {
        return [
            'wholeOwnedByUser' => $this->_wholeOwnedByUser,
            'oneOwnedByUser' => $this->_oneOwnedByUser,
        ];
    }
}