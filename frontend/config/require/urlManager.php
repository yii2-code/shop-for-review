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
    'hostInfo' => $params['frontendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'sign-in' => 'auth/user/sign-in',
        'signup' => 'auth/user/signup',
        'sign-out' => 'auth/user/sign-out',
        'active-email/<token>' => 'auth/user/active-email'
    ],
];