<?php


namespace app\components\helpers;


class HashHelper
{

    /**
     * @return string
     */
    public static function getMd5Hash()
    {
        return md5(time() . uniqid());
    }

    /**
     * @param $value
     * @return string
     */
    public static function base64Encode($value)
    {
        if (is_array($value)) {
            $value = JsonHelper::encode($value);
        }
        return base64_encode($value);
    }

    /**
     * @param $value
     * @return array|false|string
     */
    public static function base64Decode($value)
    {
        $result = base64_decode($value);
        $json = JsonHelper::decode($result);
        if (is_array($json)){
            $result = $json;
        }
        return $result;
    }

}