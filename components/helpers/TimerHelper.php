<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 18.06.17
 * Time: 22:41
 */

namespace app\components\helpers;


class TimerHelper
{
    private static $value;

    public static function start()
    {
        return self::$value = microtime(1);
    }

    public static function end($suffix = null)
    {
        return round(microtime(1) - self::$value, 3) . trim(' ' . $suffix);
    }
}