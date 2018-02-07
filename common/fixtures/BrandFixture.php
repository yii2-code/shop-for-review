<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 07.02.18
 * Time: 13:29
 */

namespace common\fixtures;


use shop\entities\Product\Brand;
use yii\test\ActiveFixture;

class BrandFixture extends ActiveFixture
{
    public function __construct(array $config = [])
    {
        $this->modelClass = Brand::class;
        $this->dataFile = __DIR__ . '/data/brand.php';
        parent::__construct($config);
    }
}