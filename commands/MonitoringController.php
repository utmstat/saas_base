<?php

namespace app\commands;

use app\components\Logger;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use yii\console\Controller;

/***
 * Class MonitoringController
 * @package app\commands
 */
class MonitoringController extends Controller
{
    public function actionIndex()
    {
        $this->checkUrls();
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
}