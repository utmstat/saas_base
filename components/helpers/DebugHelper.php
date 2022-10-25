<?php

namespace app\components\helpers;

use yii\base\Exception;

class DebugHelper
{
    public static function generateCallTrace($ignoreYiiCalls = true)
    {
        $e = new Exception();
        $trace = explode("\n", $e->getTraceAsString());
        // reverse array to make steps line up chronologically
        $trace = array_reverse($trace);
        array_shift($trace); // remove {main}
        array_pop($trace); // remove call to this method
        $result = array();

        foreach ($trace as $item) {
            $item = trim(substr($item, strpos($item, ' ')));
            if ($ignoreYiiCalls) {
                if (!TextHelper::hasText($item, 'yii')) {
                    $result[] = $item;
                }
            } else {
                $result[] = $item;
            }
        }

        return $result;
    }
}