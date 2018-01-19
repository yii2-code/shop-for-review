<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@app' => realpath(__DIR__ . '/../../app'),
        '@runtime' => '@common/runtime',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [\common\config\SetUp::class],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
            'cachePath' => '@runtime/cache'
        ],
        'db' => require __DIR__ . '/require/db.php'
    ],
];
