<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 18.02.19
 * Time: 17:07
 */

namespace app\components\common;

use app\components\Cache;
use app\components\helpers\TestHelper;
use app\models\Log;
use Codeception\Test\Unit;
use Yii;

/**
 * Class AppCodeceptionUnit
 * @package app\components\common
 */
class AppCodeceptionUnit extends Unit
{
    protected $userId = 6;

    protected function _before()
    {
        $this->clearData();
        parent::_before();
    }

    protected function clearData()
    {
        TestHelper::initFixtures();
        Yii::$app->cache->flush();
        Cache::flush();
        Log::deleteAll();

        $log = Yii::getAlias('@app') . '/runtime/logs/logger.log';
        if (file_exists($log)) {
            unlink($log);
        }
    }

}