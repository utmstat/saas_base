<?php

namespace app\commands;

use app\components\helpers\TimerHelper;
use app\components\Logger;
use app\models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use yii\console\Controller;
use yii\db\Exception;

/***
 * Class MonitoringController
 * @package app\commands
 */
class MonitoringController extends Controller
{
    public function actionIndex()
    {
        $this->checkUrls();
        $this->checkDb();
    }

    /**
     * Check URLs
     * @return void
     */
    private function checkUrls()
    {
        $client = new Client();

        $urls = [
            'https://example.com/' => 200,
        ];

        foreach ($urls as $url => $code) {
            try {
                $res = $client->request('GET', $url, ['http_errors' => false, 'timeout' => 5]);
                $msg = $url . ' - ' . $res->getStatusCode();
                if ($res->getStatusCode() !== $code) {
                    Logger::error($msg);
                } else {
                    Logger::success($msg);
                }
            } catch (GuzzleException $e) {
                $msg = $url . ' - ' . $e->getMessage();
                Logger::error($msg);
            } catch (\Exception $e) {
                $msg = $url . ' - ' . $e->getMessage();
                Logger::error($msg);
            }
        }
    }

    private function checkDb()
    {
        try {
            TimerHelper::start();
            User::findOne(1);
            Logger::success("db ok: " . TimerHelper::end('sec'));
        } catch (Exception $e) {
//            TelegramApiClient::sendCriticalMessage('db: ' . $e->getMessage());
            Logger::error("db error");
        }
    }
}