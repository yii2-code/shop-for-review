<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 07.02.18
 * Time: 15:39
 */

use shop\entities\Product\Category;
use yii\helpers\ArrayHelper;

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

$categories = array_filter(require(__DIR__ . '/../data/category.php'), function (array $array) {
    return $array['id'] != 1;
});

$categoriesId = ArrayHelper::getColumn($categories, 'id');

$brand = require(__DIR__ . '/../data/brand.php');

$brandId = ArrayHelper::getColumn($brand, 'id');

return [
    'id' => $index + 1,
    'title' => $faker->sentence(),
    'announce' => $faker->text(),
    'description' => $faker->text(),
    'price' => $faker->numberBetween(1500, 2000),
    'old_price' => rand(0, 1) ? $faker->numberBetween(1000, 1500) : null,
    'category_main_id' => $categoriesId[array_rand($categoriesId, 1)],
    'brand_id' => $brandId[array_rand($brandId, 1)],
    'status' => Category::STATUS_ACTIVE,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
];