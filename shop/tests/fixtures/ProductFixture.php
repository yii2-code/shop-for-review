<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 19:57
 */

namespace shop\tests\fixtures;


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
}