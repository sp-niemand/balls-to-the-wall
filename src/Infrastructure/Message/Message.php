<?php
/**
 * Class Message
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
 * Base message
 *
 * @category Bttw
 * @package  Infrastructure\Message
 * @author   Dmitri Cherepovski <dmitrij.cherepovskij@murka.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/sp-niemand/balls-to-the-wall
 */
abstract class Message implements \JsonSerializable
{
    const NAMESPACE_SEPARATOR = '\\';

    /**
     * Returns additional data for JSON encoding of this class instances
     *
     * @return array
     */
    protected function jsonData()
    {
        return [];
    }

    /**
     * Implements jsonSerialize() from \JsonSerializable interface
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $result = $this->jsonData();
        $result['type'] = substr(
            strrchr(static::class, self::NAMESPACE_SEPARATOR), 1
        );
        return $result;
    }
}