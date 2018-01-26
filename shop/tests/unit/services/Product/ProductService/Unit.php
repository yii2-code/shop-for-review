<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 16:08
 */

namespace shop\tests\unit\services\Product\ProductService;

use shop\services\Product\ProductService;
use shop\tests\UnitTester;

/**
 * Class Unit
 * @package shop\tests\unit\services\Product\CategoryService
 */
class Unit extends \Codeception\Test\Unit
{
    /** @var UnitTester */
    protected $tester;

    /** @var ProductService */
    public $service;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    protected function _before()
    {
        $this->service = \Yii::createObject(ProductService::class);
    }
}