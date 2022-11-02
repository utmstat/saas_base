<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 18.02.19
 * Time: 17:07
 */

namespace app\components\common;

use app\components\helpers\TestHelper;
use app\models\Project;
use app\models\User;
use Codeception\Test\Unit;
use Codeception\Util\HttpCode;

/**
 * Class AppCodeceptionUnit
 * @package app\components\common
 */
class AppCodeceptionUnit extends Unit
{
    /* @var int */
    protected $userId;

    /* @var int */
    protected $projectId;

    /* @var string */
    protected $userEmail;

    /* @var string */
    protected $userPassword;

    /* @var User */
    protected $user;

    /* @var Project */
    protected $project;

    protected function _before()
    {
        $this->init();
        parent::_before();
    }

    protected function init()
    {
        $this->user = User::findOne($this->userId);
        $this->project = Project::findOne($this->projectId);
        TestHelper::initFixtures();
        TestHelper::clearData($this->userId, $this->projectId);
    }

    /**
     * Authenticate a user
     * @param string $email
     * @param string $password
     */
    protected function login($email, $password)
    {
        $I = $this->tester;

        $fields = [
            'LoginForm[email]' => $email,
            'LoginForm[password]' => $password
        ];

        $I->amOnPage('/login/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('#login-form', $fields);
    }

    /**
     * Logout
     */
    protected function logout()
    {
        $I = $this->tester;
        $I->amOnPage('/logout/');
//        $I->seeResponseCodeIs(HttpCode::OK);
    }
}