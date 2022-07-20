<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 06.07.17
 * Time: 1:31
 */

namespace app\components\helpers;


use Yii;
use yii\web\Cookie;

/**
 * Class CookieHelper
 * @package app\components\helpers
 */
class CookieHelper
{

    /**
     * @param $name
     * @param $value
     */
    public static function set($name, $value)
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => $name,
            'value' => $value
        ]));
    }

    public static function delete($name)
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => $name,
            'value' => null,
            'expire' => time() - 86400 * 365
        ]));
    }

    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    public static function get($name, $default = null)
    {
        return Yii::$app->request->cookies->getValue($name, $default);
    }

    public static function getRaw($name, $default = null)
    {
        return ArrayHelper::getValue($_COOKIE, $name);
    }

    public static function getValueFromString($cookie, $name)
    {
        $result = [];
        $chunks = explode(';', $cookie);
        foreach ($chunks as $chunk) {
            $chunk = trim($chunk);
            if ($chunk) {
                $pair = explode('=', $chunk);
                $result[$pair[0]] = $pair[1];
            }
        }

        return ArrayHelper::getValue($result, $name);
    }
}