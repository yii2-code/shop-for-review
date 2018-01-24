<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 16:08
 */

namespace shop\tests\unit\services\Product\CategoryService;


use shop\entities\Product\Category;
use shop\services\Product\CategoryService;
use shop\tests\fixtures\CategoryFixture;
use shop\tests\UnitTester;

/**
 * Class Unit
 * @package shop\tests\unit\services\Product\CategoryService
 */
class Unit extends \Codeception\Test\Unit
{
    /** @var UnitTester */
    protected $tester;

    /** @var CategoryService */
    public $service;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    protected function _before()
    {
        $this->service = \Yii::createObject(CategoryService::class);
    }

    /**
     * @param $index
     * @return Category
     * @throws \shop\tests\_generated\ModuleException
     */
    public function grabCategory($index): Category
    {
        $this->tester->haveFixtures([
            'category' => [
                'class' => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . '/category.php'
            ]
        ]);

        return $this->tester->grabFixture('category', $index);
    }
}