<?php

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

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
                'actions' => ['signup', 'sign-in', 'reset', 'request', 'index', 'error', 'oauth'],
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
        'authClientCollection' => [
            'class' => yii\authclient\Collection::class,
            'clients' => [
                'google' => [
                    'class' => yii\authclient\clients\Google::class,
                    'clientId' => '236416334497-sc3mcf83euovrouq348ncnvk0lrsjm4l.apps.googleusercontent.com',
                    'clientSecret' => 'GoC-ixilX1Y7KzJsI-siaA44',
                    'normalizeUserAttributeMap' => [
                        'email' => function ($attribute) {
                            return ArrayHelper::getValue($attribute, ['emails', '0', 'value']);
                        },
                        'login' => 'displayName',
                    ],
                ],
                'github' => [
                    'class' => yii\authclient\clients\GitHub::class,
                    'clientId' => 'cc02942dc3008fcf6d0d',
                    'clientSecret' => 'b52d6bdf6e338739405c6383ea4afb9b6a0d1ee9',
                ],
                'twitter' => [
                    'class' => yii\authclient\clients\Twitter::class,
                    'attributeParams' => [
                        'include_email' => 'true'
                    ],
                    'consumerKey' => 'vbcpikdBbG0UzzwgkVsCcJMlc',
                    'consumerSecret' => 'jNYj2HxumLXxRDtIPkAFlwl6YAKniFGvd0xO8jUztDpnN7zjlv',
                    'normalizeUserAttributeMap' => [
                        'login' => 'screen_name',
                    ],
                ],
                'yandex' => [
                    'class' => yii\authclient\clients\Yandex::class,
                    'clientId' => 'e77b16276e33409ba104e91b49100002',
                    'clientSecret' => '8a2086e3faac4f9cba1a67fea7bf82a5',
                    'normalizeUserAttributeMap' => [
                        'login' => 'display_name',
                        'email' => ['emails', '0']
                    ],
                ],
                /*                'facebook' => [
                                    'class' => 'yii\authclient\clients\Facebook',
                                    'clientId' => 'facebook_client_id',
                                    'clientSecret' => 'facebook_client_secret',
                                ],*/
                // etc.
            ],
        ],
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
