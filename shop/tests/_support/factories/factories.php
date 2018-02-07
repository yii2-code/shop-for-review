<?php

use League\FactoryMuffin\Faker\Facade as Faker;
use shop\entities\Auth\Profile;
use shop\entities\Auth\User;
use shop\entities\Product\Brand;
use shop\entities\Product\Category;
use shop\entities\Product\Characteristic;
use shop\entities\Product\Variant;
use yii\helpers\Json;

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

$fm->define(Brand::class)->setDefinitions([
    'id' => 1,
    'title' => Faker::sentence($nbWords = 6, $variableNbWords = true),
    'description' => Faker::text(200),
    'status' => Brand::STATUS_ACTIVE,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
]);

$fm->define(Characteristic::class)->setDefinitions([
    'title' => Faker::sentence($nbWords = 6, $variableNbWords = true),
    'required' => Characteristic::REQUIRED_NO,
    'type' => Variant::TYPE_STRING,
    'default' => 'default1',
    'variants' => Json::encode(['variants1', 'variants2']),
    'position' => 0,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
]);


$fm->define(Category::class)->setDefinitions([
    'title' => Faker::sentence($nbWords = 6, $variableNbWords = true),
    'description' => Faker::text(200),
    'lft' => '1',
    'rgt' => '2',
    'depth' => '0', // not unsigned!
    'status' => Category::STATUS_ACTIVE,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
]);