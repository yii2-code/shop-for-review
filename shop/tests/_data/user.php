<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 14:24
 */

return [
    '1' => [
        'id' => 1,
        'login' => 'login1',
        'password' => password_hash('password1', PASSWORD_DEFAULT),
        'email' => 'email@test1.com',
        'request_email_token' => sprintf('%s_%s', Yii::$app->security->generateRandomString(64), time()),
        'status' => \shop\entities\Auth\User::STATUS_CONFIRM_EMAIL,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
    '2' => [
        'id' => 2,
        'login' => 'login2',
        'password' => password_hash('password2', PASSWORD_DEFAULT),
        'email' => 'email@test2.com',
        'request_email_token' => sprintf('%s_%s', Yii::$app->security->generateRandomString(64), time()),
        'status' => \shop\entities\Auth\User::STATUS_ACTIVE,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
    '3' => [
        'id' => 3,
        'login' => 'login3',
        'password' => password_hash('password3', PASSWORD_DEFAULT),
        'email' => 'email@test3.com',
        'request_email_token' => sprintf('%s_%s', Yii::$app->security->generateRandomString(64), time()),
        'status' => \shop\entities\Auth\User::STATUS_DELETE,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
];