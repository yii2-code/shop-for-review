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
                '1000x400' => [
                    'width' => 1000,
                    'height' => 400,
                    'quality' => 100,
                ]
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
            'cachePath' => '@runtime/cache'
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
            ],
        ],
        'db' => require __DIR__ . '/require/db.php'
    ],
];

return $config;