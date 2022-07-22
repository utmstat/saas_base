<?php

$apiRules = [];

$uuidRegExp = '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}';

$apiDomains = [
    'api.saas.ru'
];

foreach ($apiDomains as $domain) {
    $domainRules = [
        '//' . $domain => '/api',
        '//' . $domain . '/<controller:[a-z0-9\-]+>/<action:[a-z0-9\-]+>/' => 'api/<controller>/<action>',

    ];
    foreach ($domainRules as $key => $value) {
        $apiRules[$key] = $value;
    }
}


$commonRules = [
    '/register' => 'site/register',
    '/login' => 'site/login',
    '/logout' => 'site/logout',
    '/recovery' => 'site/recovery',
    '/reset-password/<hash:' . $uuidRegExp . '>/' => 'site/reset-password',
];

return array_merge($commonRules, $apiRules);