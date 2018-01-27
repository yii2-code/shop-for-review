<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 22:26
 */

use shop\entities\Product\Product;

return [
    '1' => [
        'id' => '1',
        'name' => 'test',
        'src' => '650x650.png',
        'class' => Product::class,
        'token' => Yii::$app->security->generateRandomString(64),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
];