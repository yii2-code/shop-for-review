<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 14.02.18
 * Time: 20:06
 */

use shop\entities\Product\Characteristic;
use shop\entities\Product\Variant;
use yii\helpers\Json;

$position = 0;

return [
    [
        'id' => 1,
        'title' => 'Color',
        'type' => Variant::TYPE_STRING,
        'required' => Characteristic::REQUIRED_YES,
        'default' => 'red',
        'variants' => Json::encode(['yellow', 'blue', 'green']),
        'position' => ++$position,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'id' => 2,
        'title' => 'Size',
        'type' => Variant::TYPE_INTEGER,
        'required' => Characteristic::REQUIRED_YES,
        'default' => 0,
        'variants' => Json::encode([101, 234, 345]),
        'position' => ++$position,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'id' => 3,
        'title' => 'Processor',
        'type' => Variant::TYPE_INTEGER,
        'required' => Characteristic::REQUIRED_NO,
        'default' => 0,
        'variants' => Json::encode([]),
        'position' => ++$position,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'id' => 4,
        'title' => 'Memory',
        'type' => Variant::TYPE_FLOAT,
        'required' => Characteristic::REQUIRED_NO,
        'variants' => Json::encode([]),
        'position' => ++$position,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
];