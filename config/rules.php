<?php

$apiRules = [];

$apiDomains = [
    'api.saas.ru',
];

foreach ($apiDomains as $domain) {
    $domainRules = [
        '//' . $domain => 'api',
        '//' . $domain . '/<controller:[a-z0-9\-]+>/<action:[a-z0-9\-]+>/' => 'api/<controller>/<action>',

    ];
    foreach ($domainRules as $key => $value) {
        $apiRules[$key] = $value;
    }
}


$commonRules = [
    '/register' => 'site/register',
    '/login' => 'site/login',
];

return array_merge($commonRules, $apiRules);