<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 20:04
 */

return [
    '1' => [
        'id' => 1,
        'title' => 'title1',
        'announce' => 'announce1',
        'description' => 'description1',
        'price' => 1200,
        'old_price' => 1000,
        'brand_id' => 1,
        'category_main_id' => 2,
        'status' => \shop\entities\Product\Product::STATUS_ACTIVE,
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ],
];