<?php

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'Shop',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', \frontend\config\SetUp::class],
    'controllerNamespace' => 'frontend\controllers',
    /*    'as access' => [
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
        ],*/
    'components' => [
        'authClientCollection' => [
            'class' => yii\authclient\Collection::class,
            'clients' => [
                'google' => [
                    'class' => yii\authclient\clients\Google::class,
                    'clientId' => getenv('OAUTH_GOOGLE_CLIENT_ID'),
                    'clientSecret' => getenv('OAUTH_GOOGLE_CLIENT_SECRET'),
                    'normalizeUserAttributeMap' => [
                        'email' => function ($attribute) {
                            return ArrayHelper::getValue($attribute, ['emails', '0', 'value']);
                        },
                        'login' => 'displayName',
                    ],
                    'title' => 'Sign in with Google',
                ],
                'github' => [
                    'class' => yii\authclient\clients\GitHub::class,
                    'clientId' => getenv('OAUTH_GITHUB_CLIENT_ID'),
                    'clientSecret' => getenv('OAUTH_GITHUB_CLIENT_SECRET'),
                    'title' => 'Sign in with GitHub',
                ],
                'twitter' => [
                    'class' => yii\authclient\clients\Twitter::class,
                    'attributeParams' => [
                        'include_email' => 'true'
                    ],
                    'consumerKey' => getenv('OAUTH_TWITTER_CLIENT_KEY'),
                    'consumerSecret' => getenv('OAUTH_TWITTER_CLIENT_SECRET'),
                    'normalizeUserAttributeMap' => [
                        'login' => 'screen_name',
                    ],
                    'title' => 'Sign in with Twitter',
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => hash('sha512', __FILE__ . __LINE__),
        ],
        'user' => [
            'identityClass' => \shop\entities\Auth\User::class,
            'loginUrl' => ['/sign-in'],
            //'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
                'domain' => getenv('COOKIE_DOMAIN'),
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => '_session',
            'cookieParams' => [
                'domain' => getenv('COOKIE_DOMAIN'),
                'httponly' => true,
            ],
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
        },
    ],
    'params' => $params,
];
