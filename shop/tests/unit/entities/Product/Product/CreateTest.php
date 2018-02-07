<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 19:55
 */

namespace shop\tests\unit\entities\Product\Product;


use Codeception\Test\Unit;
use shop\entities\Product\Brand;
use shop\entities\Product\Category;
use shop\entities\Product\Product;
use shop\tests\fixtures\CategoryFixture;
use shop\tests\UnitTester;


/**
 * Class CreateTest
 * @package shop\tests\unit\entities\Product\Product
 */
class CreateTest extends Unit
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @group  product
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        Brand::deleteAll();
        $this->tester->have(Brand::class, ['id' => 1]);
        /** @var Brand $brand */
        $brand = $this->tester->grabRecord(Brand::class, ['id' => 1]);


        $this->tester->haveFixtures([
            'category' => [
                'class' => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . '/category.php'
            ],
        ]);

        /** @var Category $category */
        $category = $this->tester->grabFixture('category', 2);

        $model = Product::create(
            $title = 'title',
            $announce = 'announce',
            $description = 'description',
            $status = Product::STATUS_ACTIVE,
            $price = 2000,
            $brand->id,
            $category->id,
            $oldPrice = 1990
        );

        $this->assertTrue($model->save(), 'Unable to save model');
        $this->tester->seeRecord(
            Product::class,
            [
                'id' => $model->id,
                'title' => $title,
                'announce' => $announce,
                'description' => $description,
                'status' => $status,
                'price' => $price,
                'brand_id' => $brand->id,
                'category_main_id' => $category->id,
                'old_price' => $oldPrice
            ]
        );
    }
}