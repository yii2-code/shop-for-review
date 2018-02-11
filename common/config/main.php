<?php

use app\modules\image\Module;

$config = [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@app' => realpath(__DIR__ . '/../../app'),
    ],
    'language' => 'ru',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [\common\config\SetUp::class, 'image'],
    'runtimePath' => '@common/runtime',
    'modules' => [
        'image' => [
            'class' => Module::class,
            'path' => Yii::getAlias('@static/image'),
            'url' => getenv('STATIC_HOST_INFO') . '/image',
            'thumbPath' => Yii::getAlias('@static/image/thumb'),
            'thumbUrl' => getenv('STATIC_HOST_INFO') . '/image/thumb',
            'placeholderPath' => Yii::getAlias('@app/modules/image/data/placeholder.png'),
            'thumbs' => [
                '1900x800' => [
                    'width' => 1900,
                    'height' => 800,
                    'quality' => 100,
                ],
                '340x250' => [
                    'width' => 340,
                    'height' => 250,
                    'quality' => 100,
                ],
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => \yii\redis\Cache::class,
            'defaultDuration' => 24 * 60 * 60,
            'keyPrefix' => hash('crc32', __FILE__),
            'redis' => [
                'hostname' => getenv('REDIS_HOST'),
            ]
        ],
        'i18n' => [
            'translations' => [
                'shop' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@shop/messages',
                ],
                'auth' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@shop/messages',
                ],
                'backend' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@backend/messages',
                ],
            ],
        ],
        'db' => require __DIR__ . '/require/db.php',
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => filter_var(getenv('MAILER_USE_FILE_TRANSPORT'), FILTER_VALIDATE_BOOLEAN),
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['172.73.251.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['172.73.251.1'],
    ];
}

return $config;
