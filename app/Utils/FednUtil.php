<?php
/**
 * Created by PhpStorm.
 * User: kaireewu
 * Date: 2016/12/18
 * Time: 13:29
 */

namespace Fedn\Utils;


class FednUtil
{
    public static function startsWith($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }

    public static function endsWith($haystack, $needle)
    {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle,
                    $temp) !== false);
    }

    public static function removeInValidUtf8Chars($some_string)
    {
        //reject overly long 2 byte sequences, as well as characters above U+10000 and replace with ?
        $some_string = preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]' .
            '|[\x00-\x7F][\x80-\xBF]+' .
            '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*' .
            '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})' .
            '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
            '?', $some_string);

        //reject overly long 3 byte sequences and UTF-16 surrogates and replace with ?
        $some_string = preg_replace('/\xE0[\x80-\x9F][\x80-\xBF]' .
            '|\xED[\xA0-\xBF][\x80-\xBF]/S', '?', $some_string);

        return $some_string;
    }
}
