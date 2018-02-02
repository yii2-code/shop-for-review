<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 19:57
 */

namespace shop\tests\fixtures;


use shop\entities\Product\Product;
use yii\test\ActiveFixture;

/**
 * Class ProductFixture
 * @package shop\tests\fixtures
 */
class ProductFixture extends ActiveFixture
{
    /**
     * @var string
     */
    public $modelClass = 'shop\entities\Product\Product';

    public function __construct(array $config = [])
    {
        $this->modelClass = Product::class;
        $this->dataFile = codecept_data_dir('product.php');
        parent::__construct($config);
    }
}