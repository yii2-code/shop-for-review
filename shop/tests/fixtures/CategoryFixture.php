<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 16:25
 */

namespace shop\tests\fixtures;


use shop\entities\Product\Category;
use yii\test\ActiveFixture;

/**
 * Class CategoryFixture
 * @package shop\tests\fixtures
 */
class CategoryFixture extends ActiveFixture
{
    /**
     * CategoryFixture constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->modelClass = Category::class;
        $this->dataFile = codecept_data_dir('category.php');
        parent::__construct($config);
    }
}