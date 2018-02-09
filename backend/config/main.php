<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-backend',
    'name' => 'Admin shop',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'container' => [
        'definitions' => [
            \app\modules\tag\widgets\TagWidget::class => [
                'clientOptions' => [
                    'url' => getenv('API_HOST_INFO') . '/tag/tag/create',
                ],
            ],

        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
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
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'backendHostInfo' => require __DIR__ . '/require/urlManager.php',
        'frontendHostInfo' => require __DIR__ . '/../../frontend/config/require/urlManager.php',
        'urlManager' => function () {
            return Yii::$app->get('backendHostInfo');
        },
    ],
    'params' => $params,
];
