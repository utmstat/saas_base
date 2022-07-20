<?php

namespace front\common;

use app\components\common\AppCodeceptionUnit;
use FrontTester;

/**
 * Class IndexActionTest
 * @package front\common
 */
class IndexActionTest extends AppCodeceptionUnit
{
    /**
     * @var FrontTester
     */
    protected $tester;

    protected $frontUrls = [
        '/',
        '/login',
        '/register',
    ];


    public function testFrontWithoutLogin()
    {
        $I = $this->tester;

        foreach ($this->frontUrls as $frontUrl) {
            $I->amOnPage($frontUrl);
            $I->seeResponseCodeIs(200);
        }
    }
}