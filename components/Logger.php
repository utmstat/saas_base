<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 09.06.17
 * Time: 2:24
 */

namespace app\components;

use app\components\helpers\DateHelper;
use app\components\helpers\JsonHelper;
use Yii;

class Logger
{

    const COLOR_SUCCESS = '0;32';

    const COLOR_ERROR = '0;31';

    const COLOR_WARNING = '1;33';

    const COLOR_TRACE = '0;36';

    public static function trace($message, $color = null)
    {
        if (!$color) {
            $color = self::COLOR_TRACE;
        }
        echo "\033[" . $color . "m" . $message . "\033[0m\r\n";
    }

    public static function error($message)
    {
        $color = self::COLOR_ERROR;

        if (is_array($message)) {
            $message = JsonHelper::encode($message);
        }

        echo "\033[" . $color . "m" . $message . "\033[0m\r\n";
    }

    public static function warning($message)
    {
        $color = self::COLOR_WARNING;
        echo "\033[" . $color . "m" . $message . "\033[0m\r\n";
    }

    public static function success($message)
    {
        $color = self::COLOR_SUCCESS;
        echo "\033[" . $color . "m" . $message . "\033[0m\r\n";
    }

    /**
     * @param $model
     * @param null $projectId
     */
    public static function logModelErrors($model, $projectId = null)
    {

        $trace = debug_backtrace();
        foreach ($trace as $key => $value) {
            unset($trace[$key]['object']);
            unset($trace[$key]['args']);
            unset($trace[$key]['type']);
        }

        $data = [
            'class' => get_class($model),
            'errors' => $model->errors,
            'trace' => $trace,
            'attrs' => $model->attributes
        ];

        Yii::error(JsonHelper::encode($data), 'save_model');
    }

    public static function logCronError($message, $projectId, $integrationId, $category)
    {
        $msg = $projectId . '/' . $integrationId . ': ' . $message;
        self::error($message);
        Yii::error($msg, $category);
    }

    public static function logToFile($content)
    {

        if (is_array($content)) {
            $content = JsonHelper::encode($content);
        }

        $file = self::getLogFile();
        $row = DateHelper::formatAsTrace(time()) . ': ' . $content . "\r\n";
        file_put_contents($file, $row, FILE_APPEND);
    }

    public static function getLogFile()
    {
        return Yii::getAlias('@app') . '/runtime/logs/logger.log';
    }

    public static function getClearLogFile()
    {
        $file = self::getLogFile();

        if (file_exists($file)) {
            unlink($file);
        }

        return $file;
    }

}