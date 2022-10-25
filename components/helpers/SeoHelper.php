<?php

namespace app\components\helpers;

class SeoHelper
{
    private static $title;

    private static $description;

    private static $ogImage = '/image/og/default/1200x600.png';

    public static function setTitle($value)
    {
        self::$title = $value;
    }

    public static function setDescription($value)
    {
        self::$description = $value;
    }

    public static function getTitle()
    {
        return self::$title;
    }

    public static function getDescription()
    {
        return self::$description;
    }

    public static function getOgImage()
    {
        return AppHelper::getFrontHost() . '/' . trim(self::$ogImage, '/');
    }
}