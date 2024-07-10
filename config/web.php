<?php

$params = require __DIR__ . '/params.php';


return [
    'id' => 'calculator-yii2',
    'name' => 'Калькулятор',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'sF6ugQqWMYrNL4Q',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ],
        ],

        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'GET,HEAD months' => 'month/index',
                'GET,HEAD months/<id:\d+>' => 'month/view',
                'POST months' => 'month/create',
                'PUT,PATCH months/<id:\d+>' => 'month/update',
                'DELETE months/<id:\d+>' => 'month/delete',
            ],
        ],
    'db' => require __DIR__ . '/db.php',
    ],
    'params' => $params,
];