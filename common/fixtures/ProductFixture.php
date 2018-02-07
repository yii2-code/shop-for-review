<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 07.02.18
 * Time: 16:12
 */

namespace common\fixtures;

use shop\entities\Product\Product;
use yii\test\ActiveFixture;

class ProductFixture extends ActiveFixture
{
    public function __construct(array $config = [])
    {
        $this->modelClass = Product::class;
        $this->dataFile = __DIR__ . '/data/product.php';
        $this->depends = [
            BrandFixture::class,
            CategoryFixture::class,
        ];
        parent::__construct($config);
    }
}