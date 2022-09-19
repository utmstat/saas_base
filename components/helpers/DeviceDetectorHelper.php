<?php


namespace app\components\helpers;


use app\components\DeviceDetector;
use Yii;

class DeviceDetectorHelper
{

    public static function isMobile()
    {
        return self::getDetector()->isMobile();
    }

    public static function isDesktop()
    {
        return self::getDetector()->isDesktop();
    }

    public static function getUserAgent()
    {
        return self::getDetector()->getUserAgent();
    }

    private static function getDetector()
    {
        $detector = new DeviceDetector(Yii::$app->request->userAgent);
        $detector->parse();
        return $detector;
    }

}