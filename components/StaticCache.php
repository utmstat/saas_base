<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 26.02.20
 * Time: 1:04
 */

namespace app\components;

use app\components\helpers\ArrayHelper;

class StaticCache
{
    private static $cache = [];

    private static function getModel($class, $condition, $mode)
    {
        $hash = md5($class . json_encode($condition) . $mode);

        if (!array_key_exists($hash, self::$cache)) {
            $result = $class::find()->where($condition)->$mode();
            self::$cache[$hash] = $result;
        }

        return self::$cache[$hash];
    }

    public static function getIndex($method, $data)
    {
        if (!is_array($data)) {
            $data = [$data];
        }
        return md5($method . json_encode($data));
    }

    public static function set($method, $data, $value)
    {
        $idx = self::getIndex($method, $data);
        self::$cache[$idx] = $value;
    }

    public static function get($method, $data)
    {
        $idx = self::getIndex($method, $data);
        return ArrayHelper::getValue(self::$cache, $idx);
    }

    public static function flush()
    {
        self::$cache = [];
    }
}