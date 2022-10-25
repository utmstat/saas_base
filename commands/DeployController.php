<?php

namespace app\commands;


use app\components\Logger;
use yii\console\Controller;

/**
 * Class DeployController
 * @package app\commands
 */
class DeployController extends Controller
{
    public function actionPreProcessing()
    {
        Logger::trace(('PRE PROCESSING'));

        Logger::trace(('DONE'));
    }

    public function actionPostProcessing()
    {
        Logger::trace('POST PROCESSING');

        Logger::trace('DONE');
    }
}