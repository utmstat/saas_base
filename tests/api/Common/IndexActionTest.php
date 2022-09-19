<?php

namespace api\Common;

use app\components\common\AppCodeceptionUnit;

/**
 * Class IndexActionTest
 * @package api\Common
 */
class IndexActionTest extends AppCodeceptionUnit
{
    /**
     * @var \ApiTester
     */
    protected $tester;

    public function testCommon()
    {
        $I = $this->tester;
        $I->sendPost('/');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}