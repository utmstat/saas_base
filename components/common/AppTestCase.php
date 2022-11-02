<?php
/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 31.05.17
 * Time: 0:29
 */

namespace app\components\common;

use app\components\helpers\TestHelper;
use app\models\Project;
use app\models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Yii;

class AppTestCase extends TestCase
{
    /* @var int */
    protected $projectId = 2;

    /* @var int */
    protected $userId = 2;

    /* @var User */
    protected $user;

    /* @var Project */
    protected $project;

    /* @var string  */
    protected $lastResponse;

    /* @var int */
    protected $lastHttpCode;

    /* @var bool */
    protected $guestMode = false;

    const TEST_USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.112 Safari/537.36 Vivaldi/1.91.867.46';


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
        return $this->user->access_token;
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
        $this->user = User::findOne($this->userId);
        $this->project = Project::findOne($this->projectId);
        TestHelper::initFixtures();
        TestHelper::clearData($this->userId, $this->projectId);
        parent::setUp();
    }
}
