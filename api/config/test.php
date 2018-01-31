<?php
return [
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
];
