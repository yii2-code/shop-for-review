<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 14.02.18
 * Time: 20:16
 */

use Faker\Factory;
use shop\entities\Product\Variant;
use yii\helpers\Json;

$faker = Factory::create();

$result = [];

$characteristics = require __DIR__ . '/characteristic.php';

$products = require __DIR__ . '/product.php';

foreach ($products as $product) {
    foreach ($characteristics as $characteristic) {
        $value = null;
        $variants = Json::decode($characteristic['variants']);
        if (!empty($variants)) {
            $value = $variants[array_rand($variants)];
        } else {
            if ($characteristic['type'] == Variant::TYPE_STRING) {
                $value = $faker->word;
            } else if ($characteristic['type'] == Variant::TYPE_INTEGER) {
                $value = $faker->numberBetween();
            } else if ($characteristic['type'] == Variant::TYPE_FLOAT) {
                $value = $faker->randomFloat();
            }
        }
        $result[] = [
            'product_id' => $product['id'],
            'characteristic_id' => $characteristic['id'],
            'value' => $value,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}

return $result;