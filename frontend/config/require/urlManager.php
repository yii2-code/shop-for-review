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
    'hostInfo' => getenv('FRONTEND_HOST_INFO'),
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'sign-in' => 'auth/user/sign-in',
        'oauth' => 'auth/user/oauth',
        'signup' => 'auth/user/signup',
        'sign-out' => 'auth/user/sign-out',
        'active-email/<token>' => 'auth/user/active-email',
        'request-reset' => 'auth/password-reset/request',
        'reset/<token>' => 'auth/password-reset/reset',
    ],
];