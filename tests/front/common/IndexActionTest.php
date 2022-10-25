<?php

namespace front\common;

use app\components\common\AppCodeceptionUnit;
use app\models\User;
use FrontTester;

/**
 * Class IndexActionTest
 * @package front\common
 */
class IndexActionTest extends AppCodeceptionUnit
{
    /* @var FrontTester */
    protected $tester;

    protected $frontUrls = [
        '/',
        '/login',
        '/register',
    ];

    protected $frontUrlsAuthorized = [

    ];

    protected $commonUrls = [
    ];


    public function testFrontWithoutLogin()
    {
        $I = $this->tester;

        $I->stopFollowingRedirects();

        foreach ($this->frontUrls as $frontUrl) {
            $I->amOnPage($frontUrl);
            $I->seeResponseCodeIs(200);
        }

        foreach ($this->commonUrls as $frontUrl) {
            $I->amOnPage($frontUrl);
            $I->seeResponseCodeIs(200);
        }

        foreach ($this->frontUrlsAuthorized as $frontUrl) {
            $I->amOnPage($frontUrl);
            $I->seeResponseCodeIs(302);
        }
    }

    public function testFrontWithLogin()
    {
        $I = $this->tester;
        $user = User::findOne($this->userId);
        $I->assertInstanceOf(User::class, $user);

        $this->login($this->userEmail, $this->userPassword);

        $I->stopFollowingRedirects();

        foreach ($this->frontUrlsAuthorized as $frontUrl) {
            $I->amOnPage($frontUrl);
            $I->seeResponseCodeIs(200);
        }

        foreach ($this->commonUrls as $frontUrl) {
            $I->amOnPage($frontUrl);
            $I->seeResponseCodeIs(200);
        }

        $this->logout();
    }

}