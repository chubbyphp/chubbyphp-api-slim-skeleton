<?php

use Slim\Container;

/** @var Container $container */

return [
    'settings' => [
        'httpVersion' => '1.1',
        'responseChunkSize' => 4096,
        'outputBuffering' => 'append',
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => false,
        'addContentLengthHeader' => true,
        'routerCacheFile' => $container['cacheDir'].'/routes.php',
    ],
    'projectSettings' => [
        'api-http.request.accepted' => [
            'application/json',
            'application/x-www-form-urlencoded',
            'application/xml',
            'application/x-yaml',
        ],
        'api-http.request.acceptedLanguages' => ['de', 'en'],
        'api-http.request.contentTypes' => [
            'application/json',
            'application/x-www-form-urlencoded',
            'application/xml',
            'application/x-yaml',
        ],
        'db.options' => [
            'driver' => 'pdo_mysql',
            'host' => '127.0.0.1',
            'port' => 3306,
            'dbname' => 'chubbyphp_api_skeleton',
            'user' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'debug' => false,
        'defaultLanguage' => 'en',
        'monolog.logfile' => $container['logDir'].'/application-'.(new \DateTime())->format('Y-m-d').'.log',
        'monolog.level' => 'notice',
        'swiftmailer.options' => [
            'host' => 'smtp.gmail.com',
            'port' => '465',
            'username' => 'firstname.lastname@gmail.com',
            'password' => 'MhZtGShTa65Gta54',
            'encryption' => 'ssl',
            'auth_mode' => 'login'
        ],
        'swiftmailer.use_spool' => false
    ],
];
