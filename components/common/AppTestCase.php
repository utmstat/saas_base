<?php
/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 31.05.17
 * Time: 0:29
 */

namespace app\components\common;

use app\components\Cache;
use app\components\helpers\TestHelper;
use app\models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Yii;

class AppTestCase extends TestCase
{
    protected $appPath;
    protected $projectId;
    protected $userId;
    protected $front_url;
    protected $api_url;
    protected $api_token;
    protected $lastResponse;
    protected $lastHttpCode;
    protected $guestMode = false;

    const TEST_USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.112 Safari/537.36 Vivaldi/1.91.867.46';

    /**
     * @var User
     */
    protected $user;

    protected function getClient()
    {
        return new Client();
    }

    /**
     * @param $url
     * @param array $params
     * @param string $method
     *
     * @throws GuzzleException
     */
    protected function send($url, $params = [], $method = 'POST')
    {
        if (!$this->guestMode) {
            $url .= '?' . http_build_query(['access-token' => $this->getApiToken()]);
        }

        if ($method === 'POST') {
            $r = $this->getClient()->request('POST', $url, [
                'form_params' => $params
            ]);
        } else {
            $r = $this->getClient()->request('GET', $url);
        }
        $response = $r->getBody()->getContents();
        $this->lastHttpCode = $r->getStatusCode();
        $this->lastResponse = json_decode($response, true);
    }

    protected function getDomain()
    {
        return Yii::$app->urlManager->hostInfo;
    }

    private function getApiToken()
    {
        $model = User::find()->one();
        return $model->getApiToken();
    }

    protected function initUser($userId = null)
    {
        if (!$userId) {
            $userId = $this->userId;
        }

        $user = User::findOne($userId);

        if($user) {
            Yii::$app->user->switchIdentity(new User([
                'id' => $user->id,
                'username' => $user->email,
                'authKey' => $user->auth_key,
            ]));
        }
    }

    public function setUp(): void
    {
        TestHelper::initFixtures();

        $this->appPath = Yii::getAlias('@app');

        $log = Yii::getAlias('@app') . '/runtime/logs/logger.log';
        if (file_exists($log)) {
            unlink($log);
        }

        Yii::$app->cache->flush();
        Cache::flush();

        parent::setUp();
    }
}
