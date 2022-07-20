<?php
/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 05.09.15
 * Time: 2:24
 */

namespace app\components\helpers;

use claviska\SimpleImage;
use Yii;
use yii\helpers\FileHelper;

class ImageHelper
{
    const WEB_ROOT = '/images/resized';

    public static function getResizeToHeight($url, $height)
    {
        $result = null;

        if ($url) {

            $ext = pathinfo($url, PATHINFO_EXTENSION);

            if (!$ext || strlen($ext) > 5) {
                $ext = 'png';
            }

            $filename = self::getDir() . '/h_' . $height . '_' . md5($url) . '.' . $ext;

            if (!file_exists($filename)) {
                try {
                    $simpleImage = new SimpleImage($url);
                    $simpleImage->fitToHeight($height)->toFile($filename);
                } catch (\Exception $e) {
                    Yii::error($e->getMessage(), __METHOD__);

                    return self::getResizeToHeight(Yii::getAlias('@webroot') . '/images/no_image.png', $height);
                }
            }

            $result = self::WEB_ROOT . '/' . basename($filename);
        }

        return $result;
    }

    public static function getResizeToWidth($url, $width, $forceJpg = true)
    {
        $result = null;

        if ($url) {

            $ext = pathinfo($url, PATHINFO_EXTENSION);

            if (!$ext || strlen($ext) > 5) {
                $ext = 'png';
            }

            if ($forceJpg) {
                $ext = 'jpg';
            }

            $filename = self::getDir() . '/w_' . $width . '_' . md5($url) . '.' . $ext;

            if (!file_exists($filename)) {
                try {
                    $simpleImage = new SimpleImage($url);
                    $simpleImage
                        ->resize($width)
                        ->toFile($filename);
                } catch (\Exception $e) {
                    Yii::error($e->getMessage(), __METHOD__);

                    return self::getResizeToWidth(Yii::getAlias('@webroot') . '/images/no_image.png', $width, $forceJpg);
                }
            }

            $result = self::WEB_ROOT . '/' . basename($filename);
        }

        return $result;
    }

    public static function resizeTo($url, $w, $h, $color = 'white', $xOffset = 0, $yOffset = 0, $wCorrection = 0, $hCorrection = 0)
    {
        if (!$url) {
            return self::resizeTo(Yii::getAlias('@webroot') . '/images/no_image.png', $w, $h, $color, $xOffset, $yOffset, $wCorrection, $hCorrection);
        }

        $ext = pathinfo($url, PATHINFO_EXTENSION);
        $params = [
            $color,
            $xOffset,
            $yOffset,
            $wCorrection,
            $hCorrection
        ];
        $filename = self::getDir() . '/' . $w . 'x' . $h . '_' . implode('_', $params) . '_' . md5($url) . '.' . $ext;
        if (!file_exists($filename)) {

            try {
                $originImg = new SimpleImage($url);

                $originWidth = $originImg->getWidth();
                $originHeight = $originImg->getHeight();

                if ($originWidth / $w > $originHeight / $h) {
                    $originImg->fitToWidth($w + $wCorrection);
                } else {
                    $originImg->fitToHeight($h + $hCorrection);
                }

                $img = new SimpleImage();
                $img->fromNew($w, $h, $color);
                $img->overlay($originImg, 'center', 1, $xOffset, $yOffset);
                $img->toFile($filename, 'image/png');
            } catch (\Exception $e) {
                Yii::error($e->getMessage(), __METHOD__);

                return self::resizeTo(Yii::getAlias('@webroot') . '/images/no_image.png', $w, $h, $color, $xOffset, $yOffset, $wCorrection, $hCorrection);
            }

        }

        return self::WEB_ROOT . '/' . basename($filename);
    }

    public static function decToHexColor($rgb)
    {
        $hex = "#";
        $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

        return $hex;
    }

    private static function getDir()
    {
        return Yii::getAlias('@app') . '/web' . self::WEB_ROOT;
    }

    public static function copyUrlToFile($url, $filename)
    {
        FileHelper::createDirectory(dirname($filename));
        $simpleImage = new SimpleImage($url);
        $simpleImage->toFile($filename);
    }
}