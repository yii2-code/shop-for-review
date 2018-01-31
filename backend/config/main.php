<?php

use backend\modules\image\Module;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'image'],
    'modules' => [
        'image' => [
            'class' => Module::class,
            'path' => Yii::getAlias('@static/image'),
            'url' => 'http://static.shop.app/image',
            'thumbPath' => Yii::getAlias('@static/image/thumb'),
            'thumbUrl' => 'http://static.shop.app/image/thumb',
        ],
        'tag' => [
            'class' => \backend\modules\tag\Module::class,
            'controllerNamespace' => 'backend\modules\tag\controllers\api',
        ]
    ],
    'container' => [
        'definitions' => [
            \backend\modules\tag\widgets\TagWidget::class => [
                'clientOptions' => [
                    'url' => 'http://cp.shop.app/tag/tag/create',
                ],
            ],
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
