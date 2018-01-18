<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 14:24
 */

return [
    [
        'id' => 1,
        'login' => 'test',
        'password' => password_hash('test', PASSWORD_DEFAULT),
        'email' => 'email@test.com',
        'request_email_token' => Yii::$app->security->generateRandomString(64),
        'status' => \shop\entities\Auth\User::STATUS_CONFIRM_EMAIL,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ]
];