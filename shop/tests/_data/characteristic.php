<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 17:23
 */


return [
    '1' => [
        'id' => 1,
        'title' => 'test1',
        'required' => \shop\entities\Product\Characteristic::REQUIRED_NO,
        'type' => \shop\entities\Product\Variant::TYPE_STRING,
        'default' => 'default1',
        'variants' => \yii\helpers\Json::encode(['variants1', 'variants2']),
        'position' => 0,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
    '2' => [
        'id' => 2,
        'title' => 'test2',
        'required' => \shop\entities\Product\Characteristic::REQUIRED_YES,
        'type' => \shop\entities\Product\Variant::TYPE_STRING,
        'default' => 'default2',
        'variants' => \yii\helpers\Json::encode(['variants3', 'variants4']),
        'position' => 1,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
    '3' => [
        'id' => 3,
        'title' => 'test3',
        'required' => \shop\entities\Product\Characteristic::REQUIRED_NO,
        'type' => \shop\entities\Product\Variant::TYPE_INTEGER,
        'default' => 300,
        'variants' => \yii\helpers\Json::encode([400, 500]),
        'position' => 2,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
    '4' => [
        'id' => 4,
        'title' => 'test4',
        'required' => \shop\entities\Product\Characteristic::REQUIRED_NO,
        'type' => \shop\entities\Product\Variant::TYPE_FLOAT,
        'default' => 300.01,
        'variants' => \yii\helpers\Json::encode([400.5, 500.8]),
        'position' => 3,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
];