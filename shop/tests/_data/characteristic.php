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
        'type' => \shop\entities\Product\Characteristic::TYPE_STRING,
        'default' => 'default1',
        'variants' => \yii\helpers\Json::encode(['variants1', 'variants2']),
        'position' => 0,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
];