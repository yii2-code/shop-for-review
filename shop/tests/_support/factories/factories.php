<?php

use League\FactoryMuffin\Faker\Facade as Faker;
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