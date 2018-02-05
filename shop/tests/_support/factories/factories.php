<?php

use League\FactoryMuffin\Faker\Facade as Faker;
use shop\entities\Auth\Profile;
use shop\entities\Auth\User;

/** @var $fm \League\FactoryMuffin\FactoryMuffin */

$fm->define(User::class)->setDefinitions([
    'id' => null,
    'login' => Faker::name(),
    'email' => Faker::email(),
    'password' => \shop\helpers\UserHelper::generatePasswordHash('password'),
    'status' => User::STATUS_ACTIVE,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s')
]);

$fm->define(Profile::class)->setDefinitions(
    [
        'user_id' => 'factory|' . User::class,
        'first_name' => Faker::firstName(),
        'middle_name' => Faker::firstName(),
        'last_name' => Faker::lastName(),
        'about' => Faker::text(200),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]
);