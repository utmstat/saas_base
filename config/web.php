<?php

$db = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/db.php'),
    require(__DIR__ . '/db.local.php')
);

$params = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params.local.php')
);

$rules = require(__DIR__ . '/rules.php');

$config = [
    'id' => 'basic',
    'language' => 'ru_RU',
    'timeZone' => 'Europe/Moscow',
    'name' => 'SAAS',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DFIKxAXsU0wwUNK8KmxZ_BXhdmx-_CSV',
        ],
        'cache' => [
            'class' => yii\caching\FileCache::class,
        ],
        'user' => [
            'identityClass' => app\models\User::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => yii\log\DbTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '/',
            'normalizer' => [
                'class' => yii\web\UrlNormalizer::class,
                'normalizeTrailingSlash' => true,
                'collapseSlashes' => true,
            ],
            'rules' => $rules,
        ],
    ],
    'container' => [
        'definitions' => [
            yii\widgets\LinkPager::class => yii\bootstrap4\LinkPager::class,
        ],
    ],
    'modules' => [
        'api' => [
            'class' => app\modules\api\Module::class,
        ],
        'support' => [
            'class' => app\modules\support\Module::class,
        ],
        'admin' => [
            'class' => app\modules\admin\Module::class,
        ],
    ],
    'params' => $params,
];

if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.1'],
    ];
}

return $config;
