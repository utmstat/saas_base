<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 04.06.17
 * Time: 1:03
 */

namespace app\components\helpers;


class JsonHelper
{

    public static function encode($str, $flags = [])
    {
        $options = JSON_UNESCAPED_UNICODE;
        foreach ($flags as $flag) {
            $options = $options | $flag;
        }

        return json_encode($str, $options);
    }

    public static function decode($str, $flags = [])
    {
        $options = JSON_UNESCAPED_UNICODE;
        foreach ($flags as $flag) {
            $options = $options | $flag;
        }

        return json_decode($str, true, 512, $options);
    }

    public static function encodeForLog($raw)
    {
        if (!is_array($raw)) {
            $raw = json_decode($raw, 1);
        }
        $result = self::encode($raw, [JSON_PRETTY_PRINT]);
        $result = strip_tags($result);
        return $result;
    }

}