<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 17.01.18
 * Time: 15:25
 */

/** @var $params array */

return [
    'class' => \yii\web\UrlManager::class,
    'hostInfo' => getenv('BACKEND_HOST_INFO'),
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'sign-in' => 'auth/auth/sign-in',
        'sign-out' => 'auth/auth/sign-out',
    ],
];