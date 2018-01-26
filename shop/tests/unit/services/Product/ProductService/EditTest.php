<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 12:43
 */

namespace shop\tests\unit\services\Product\ProductService;


use shop\entities\Product\Brand;
use shop\entities\Product\Category;
use shop\entities\Product\Product;
use shop\tests\fixtures\BrandFixture;
use shop\tests\fixtures\CategoryFixture;
use shop\tests\fixtures\ProductFixture;

/**
 * Class EditTest
 * @package shop\tests\unit\services\Product\ProductService
 */
class EditTest extends Unit
{

    /**
     * @group product
     * @throws \shop\tests\_generated\ModuleException
     * @throws \yii\web\NotFoundHttpException
     */
    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'product' => [
                'class' => ProductFixture::class,
                'dataFile' => codecept_data_dir() . '/product.php'
            ],
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

        /** @var Brand $brand */
        $brand = $this->tester->grabFixture('brand', 2);
        /** @var Category $category */
        $category = $this->tester->grabFixture('category', 3);

        $type = $this->service->createType($product);
        $type->title = 'title';
        $type->description = 'description';
        $type->announce = 'announce';
        $type->status = Product::STATUS_ACTIVE;
        $type->brandId = $brand->id;
        $type->categoryMainId = $category->id;

        $model = $this->service->edit($product->id, $type);

        $this->assertEquals($model->id, $product->id);

        $this->tester->seeRecord(
            Product::class,
            [
                'id' => $product->id,
                'title' => $type->title,
                'announce' => $type->announce,
                'description' => $type->description,
                'status' => $type->status,
                'brand_id' => $brand->id,
                'category_main_id' => $category->id,
            ]
        );
    }
}