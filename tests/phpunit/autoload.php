<?php

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../config/test.php'),
    require(__DIR__ . '/../../config/test.local.php')
);

(new yii\web\Application($config));