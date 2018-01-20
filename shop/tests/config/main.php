<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 17.01.18
 * Time: 20:02
 */
$params = array_merge(
    require __DIR__ . '/../../../common/config/params.php',
    require __DIR__ . '/../../../common/config/params-local.php'
);

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../../common/config/main.php',
    require __DIR__ . '/../../../common/config/main-local.php',
    require __DIR__ . '/../../../common/config/test.php',
    require __DIR__ . '/../../../common/config/test-local.php',
    [
        'components' => [
            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@shop/mail',
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
                'useFileTransport' => true,
                'messageConfig' => [
                    'from' => 'test@email.com'
                ]
            ],
        ],
        'params' => $params
    ]
);

return $config;