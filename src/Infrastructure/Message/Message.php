<?php
/**
 * Class Message
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
abstract class Message implements \JsonSerializable
{
    const NAMESPACE_SEPARATOR = '\\';

    /**
     * @return array
     */
    protected function jsonData()
    {
        return [];
    }

    public function jsonSerialize()
    {
        $result = $this->jsonData();
        $result['type'] = substr(strrchr(static::class, self::NAMESPACE_SEPARATOR), 1);
        return $result;
    }
}