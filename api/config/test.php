<?php

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    [
        'id' => 'app-api-tests',
        'components' => [
            'urlManager' => [
                'enablePrettyUrl' => false,
                'enableStrictParsing' => false,
                'rules' => [
                    ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
                ],
            ],
        ],
    ]
);