<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationNamespaces' => [
                'shop\migrations',
                'app\modules\image\migrations',
                'app\modules\tag\migrations',
                'console\migrations',
            ],
            'migrationPath' => null,
        ],
        'fixture' => [
            'class' => yii\faker\FixtureController::class,
            'fixtureDataPath' => Yii::getAlias('@common/fixtures/data'),
            'namespace' => 'common\fixtures',
            'templatePath' => Yii::getAlias('@common/fixtures/template'),
        ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
