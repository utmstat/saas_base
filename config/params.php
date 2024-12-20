<?php

return [
    'isProduction' => true,
    'host' => '',
    'apiHost' => '',
    'staticHost' => '',
    'devHosts' => [
        'saasbase.ru'
    ],
    'ticketEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'bsVersion' => 4,
    'phones' => [
        'label' => '8 (800) 123-45-67',
        'raw' => '+78001234567'
    ],
    'adminsEmail' => [
        'admin@example.com'
    ],
    'supportEmail' => [
        'support@example.com'
    ],
    'credentials' => require(__DIR__ . '/credentials.php'),
    'testCredentials' => require(__DIR__ . '/test_credentials.php')
];
