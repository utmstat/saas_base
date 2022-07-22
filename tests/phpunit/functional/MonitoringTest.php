<?php

namespace phpunit\functional;

use app\components\common\AppTestCase;
use app\components\helpers\ConsoleHelper;

class MonitoringTest extends AppTestCase
{
    public function testCommon()
    {
        $result = ConsoleHelper::yiiCommand('monitoring');
        self::assertNotEmpty($result);
    }
}