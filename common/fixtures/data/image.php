<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 07.02.18
 * Time: 16:27
 */

use app\modules\image\models\Image;
use shop\entities\Product\Product;
use yii\helpers\FileHelper;

$products = require('product.php');

$result = [];
$faker = Faker\Factory::create();


FileHelper::createDirectory(Yii::getAlias('@static/image'), 0777);

$files = FileHelper::findFiles(Yii::getAlias('@static/image'));

foreach ($files as $file) {
    unlink($file);
}

foreach ($products as $product) {
    for ($index = 1; $index <= 11; $index++) {

        if ($index == 1) {
            $pathFile = $faker->image(Yii::getAlias('@static/image'), 1900, 800);
        } else {
            $pathFile = $faker->image(Yii::getAlias('@static/image'), rand(100, 1000), rand(100, 1000));
        }


        $result[] = [
            'src' => pathinfo($pathFile, PATHINFO_BASENAME),
            'name' => $faker->word,
            'class' => Product::class,
            'record_id' => $product['id'],
            'token' => null,
            'position' => $index,
            'main' => $index == 1 ? Image::MAIN : null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }

}

return $result;

