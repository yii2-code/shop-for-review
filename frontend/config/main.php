<?php

use yii\filters\AccessControl;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', \frontend\config\SetUp::class],
    'controllerNamespace' => 'frontend\controllers',
    'as access' => [
        'class' => AccessControl::class,
        'rules' => [
            [
                'controllers' => ['auth/user', 'auth/password-reset', 'site'],
                'actions' => ['signup', 'sign-in', 'reset', 'request', 'index', 'error'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'controllers' => ['auth/user', 'site'],
                'actions' => ['sign-out', 'index', 'error'],
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => \shop\entities\Auth\User::class,
            //'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/frontend.log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'backendHostInfo' => require __DIR__ . '/../../backend/config/require/urlManager.php',
        'frontendHostInfo' => require __DIR__ . '/require/urlManager.php',
        'urlManager' => function () {
            return Yii::$app->get('frontendHostInfo');
        }
    ],
    'params' => $params,
];
