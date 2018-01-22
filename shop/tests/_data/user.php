<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 14:24
 */

use shop\entities\Auth\User;
use shop\helpers\UserHelper;

return [
    '1' => [
        'id' => 1,
        'login' => 'login1',
        'password' => password_hash('password1', PASSWORD_DEFAULT),
        'email' => 'email@test1.com',
        'email_active_token' => UserHelper::generateEmailActive(),
        'status' => User::STATUS_CONFIRM_EMAIL,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
    '2' => [
        'id' => 2,
        'login' => 'login2',
        'password' => password_hash('password2', PASSWORD_DEFAULT),
        'email' => 'email@test2.com',
        'email_active_token' => UserHelper::generateEmailActive(),
        'password_reset_token' => UserHelper::generatePasswordReset(),
        'status' => User::STATUS_ACTIVE,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
    '3' => [
        'id' => 3,
        'login' => 'login3',
        'password' => password_hash('password3', PASSWORD_DEFAULT),
        'email' => 'email@test3.com',
        'email_active_token' => UserHelper::generateEmailActive(),
        'status' => User::STATUS_DELETE,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
    '4' => [
        'id' => 4,
        'login' => 'login4',
        'password' => password_hash('password4', PASSWORD_DEFAULT),
        'email' => 'email@test4.com',
        'email_active_token' => UserHelper::generateEmailActive(),
        'status' => User::STATUS_ACTIVE,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
];