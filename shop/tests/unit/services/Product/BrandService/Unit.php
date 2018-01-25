<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 16:08
 */

namespace shop\tests\unit\services\Product\BrandService;


use shop\entities\Product\Brand;
use shop\services\Product\BrandService;
use shop\tests\fixtures\BrandFixture;
use shop\tests\UnitTester;

/**
 * Class Unit
 * @package shop\tests\unit\services\Product\CategoryService
 */
class Unit extends \Codeception\Test\Unit
{
    /** @var UnitTester */
    protected $tester;

    /** @var BrandService */
    public $service;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    protected function _before()
    {
        $this->service = \Yii::createObject(BrandService::class);
    }

    /**
     * @param $index
     * @return Brand
     * @throws \shop\tests\_generated\ModuleException
     */
    public function grabBrand($index): Brand
    {
        $this->tester->haveFixtures([
            'brand' => [
                'class' => BrandFixture::class,
                'dataFile' => codecept_data_dir() . '/brand.php'
            ]
        ]);

        return $this->tester->grabFixture('brand', $index);
    }
}