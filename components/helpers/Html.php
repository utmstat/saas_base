<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 17.08.20
 * Time: 11:33
 */

namespace app\components\helpers;

use Exception;

/**
 * Class Html
 * @package app\components\helpers
 */
class Html extends \yii\helpers\Html
{
    /**
     * @param string $text
     * @param null $url
     * @param array $options
     * @return string
     * @throws Exception
     */
    public static function a($text, $url = null, $options = [])
    {
        $disabled = ArrayHelper::getValue($options['disabled'], false);
        if ($disabled) {
            return parent::button($text, $options);
        }

        return parent::a($text, $url, $options);
    }
}