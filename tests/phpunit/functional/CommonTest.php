<?php

namespace phpunit\functional;

use app\components\common\AppTestCase;
use app\components\helpers\ConsoleHelper;

class CommonTest extends AppTestCase
{
    public function testCommon()
    {
        $result = ConsoleHelper::yiiCommand('deploy/pre-processing');
        self::assertNotEmpty($result);
    }
}