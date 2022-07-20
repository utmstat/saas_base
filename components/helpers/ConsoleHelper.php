<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 04.03.18
 * Time: 14:38
 */

namespace app\components\helpers;

use app\components\Logger;
use Yii;

class ConsoleHelper
{
    public static function execute($command)
    {
        Logger::trace('Execute: ' . $command);

        $output = [];
        return exec($command, $output);
    }

    public static function yiiCommand($command)
    {
        $str = 'php ' . Yii::getAlias('@app') . '/yii ' . $command;
        return self::execute($str);
    }

    public static function yiiStreamCommand($command, $streams = [])
    {
        foreach ($streams as $stream) {
            self::yiiCommand($command . ' ' . $stream);
        }
    }

    public static function grepProcesses($needle)
    {
        $output = [];
        $command = 'ps aux | grep ' . $needle;
        return exec($command, $output);
    }
}
