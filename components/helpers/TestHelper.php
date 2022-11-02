<?php

namespace app\components\helpers;

use app\components\Cache;
use app\models\ApiError;
use app\models\Integration;
use app\models\Log;
use app\models\Webhook;
use app\models\WebhookQueue;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;

/**
 * Class TestHelper
 * @package app\components\helpers
 */
class TestHelper
{
    /**
     * Init fixtures
     */
    public static function initFixtures()
    {
        $sqlDataDir = Yii::getAlias('@app') . '/tests/_data/sql/';
        $files = FileHelper::findFiles($sqlDataDir);

        foreach ($files as $file) {
            $content = file_get_contents($file);
            $queries = array_filter(array_map('trim', explode(";\n", $content)));

            foreach ($queries as $query) {
//                Logger::trace('Executing sql: ' . StringHelper::truncate($query, 120, '[... hidden]'));
                Yii::$app->db->createCommand($query)->execute();
            }
        }
    }

    public static function getCredentialValue($key)
    {
        $result = ArrayHelper::getValue(Yii::$app->params['testCredentials'], $key);

        if (!$result) {
            throw new Exception('Значение доя ' . $key . ' не найдено');
        }

        return $result;
    }

    public static function clearData($userId, $projectId)
    {
        Log::deleteAll();

        $log = Yii::getAlias('@app') . '/runtime/logs/logger.log';
        if (file_exists($log)) {
            unlink($log);
        }

        Yii::$app->cache->flush();
        Cache::flush();
    }
}