<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 16:26
 */

use shop\entities\Product\Category;

return [
    1 => [
        'id' => 1,
        'title' => 'Title1',
        'description' => 'Description1',
        'lft' => '1',
        'rgt' => '6',
        'depth' => '1', // not unsigned!
        'status' => Category::STATUS_ACTIVE,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    2 => [
        'id' => 2,
        'title' => 'Title2',
        'description' => 'Description2',
        'lft' => '2',
        'rgt' => '3',
        'depth' => '1', // not unsigned!
        'status' => Category::STATUS_ACTIVE,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    3 => [
        'id' => 3,
        'title' => 'Title3',
        'description' => 'Description3',
        'lft' => '4',
        'rgt' => '5',
        'depth' => '1', // not unsigned!
        'status' => Category::STATUS_ACTIVE,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]
];