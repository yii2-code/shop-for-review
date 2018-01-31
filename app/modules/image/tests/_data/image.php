<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 22:26
 */

use app\modules\image\models\Image;
use shop\entities\Product\Product;

return [
    '1' => [
        'id' => '1',
        'name' => 'test1',
        'src' => '650x650.png',
        'class' => Product::class,
        'token' => 'aIByYHsx34x3Fb6pwlWFBEwqs_rKJddMSl1jk2eIOCuklLeB5IU44_dDpyd',
        'position' => '1',
        'main' => Image::MAIN,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    '2' => [
        'id' => '2',
        'name' => 'test2',
        'src' => '650x650.png',
        'class' => Product::class,
        'token' => 'aIByYHsx34x3Fb6pwlWFBEwqs_rKJddMSl1jk2eIOCuklLeB5IU44_dDpyd',
        'position' => '2',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    '3' => [
        'id' => '3',
        'name' => 'test3',
        'src' => '650x650.png',
        'class' => Product::class,
        'record_id' => 1,
        'position' => '1',
        'main' => Image::MAIN,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    '4' => [
        'id' => '4',
        'name' => 'test4',
        'src' => '650x650.png',
        'class' => Product::class,
        'record_id' => 1,
        'position' => '2',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
];