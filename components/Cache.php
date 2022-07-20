<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 18.05.20
 * Time: 20:57
 */

namespace app\components;

use Yii;

/**
 * Class Cache
 * @package app\components
 */
class Cache
{

    /**
     * @param string $key
     * @param mixed $value
     * @param int $duration
     * @return bool
     */
    public static function set($key, $value, $duration)
    {
        return Yii::$app->cache->set($key, $value, $duration);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        return Yii::$app->cache->get($key);
    }

    /**
     * @param mixed $values
     * @return string
     */
    public static function getKey($values)
    {
        return md5(json_encode($values));
    }

    public static function flush(): void
    {
        Yii::$app->cache->flush();
    }
}