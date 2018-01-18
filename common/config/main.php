<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@app' => realpath(__DIR__ . '/../../app'),
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
            'cachePath' => '@common/runtime/cache'
        ],
        'db' => require __DIR__ . '/require/db.php'
    ],
];
