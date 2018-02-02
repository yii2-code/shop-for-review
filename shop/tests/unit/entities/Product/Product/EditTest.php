<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 21:12
 */

namespace shop\tests\unit\entities\Product\Product;


use Codeception\Test\Unit;
use shop\entities\Product\Product;
use shop\tests\fixtures\BrandFixture;
use shop\tests\fixtures\CategoryFixture;
use shop\tests\fixtures\ProductFixture;
use shop\tests\UnitTester;

/**
 * Class EditTest
 * @package shop\tests\unit\entities\Product\Product
 */
class EditTest extends Unit
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @group product
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'product' => ProductFixture::class,
            'brand' => [
                'class' => BrandFixture::class,
                'dataFile' => codecept_data_dir() . '/brand.php'
            ],
            'category' => [
                'class' => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . '/category.php'
            ],
        ]);

        /** @var Product $product */
        $product = $this->tester->grabFixture('product', 1);

        $product->edit(
            $title = 'title',
            $announce = 'announce',
            $description = 'description',
            $status = Product::STATUS_ACTIVE,
            $product->brand->id,
            $product->categoryMain->id
        );

        $this->assertTrue($product->save(), 'Unable to save model');

        $this->tester->seeRecord(
            Product::class,
            [
                'id' => $product->id,
                'title' => $title,
                'announce' => $announce,
                'description' => $description,
                'status' => $status,
                'brand_id' => $product->brand->id,
                'category_main_id' => $product->categoryMain->id,
            ]
        );
    }
}