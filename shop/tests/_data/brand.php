<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 12:19
 */

return [
    '1' => [
        'id' => 1,
        'title' => 'title1',
        'description' => 'description1',
        'status' => \shop\entities\Product\Brand::STATUS_ACTIVE,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
    '2' => [
        'id' => 2,
        'title' => 'title2',
        'description' => 'description2',
        'status' => \shop\entities\Product\Brand::STATUS_ACTIVE,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
];