<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 12:11
 */

namespace shop\tests\unit\services\Product\ProductService;

use shop\entities\Product\Brand;
use shop\entities\Product\Category;
use shop\entities\Product\Product;
use shop\tests\fixtures\BrandFixture;
use shop\tests\fixtures\CategoryFixture;

/**
 * Class CreateTest
 * @package shop\tests\unit\services\Product\ProductService
 */
class CreateTest extends Unit
{
    /**
     * @group product
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'brand' => [
                'class' => BrandFixture::class,
                'dataFile' => codecept_data_dir() . '/brand.php'
            ],
            'category' => [
                'class' => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . '/category.php'
            ],
        ]);

        /** @var Brand $brand */
        $brand = $this->tester->grabFixture('brand', 1);
        /** @var Category $category */
        $category = $this->tester->grabFixture('category', 2);

        $type = $this->service->createType();
        $type->title = 'title';
        $type->description = 'description';
        $type->announce = 'announce';
        $type->status = Product::STATUS_ACTIVE;
        $type->brandId = $brand->id;
        $type->categoryMainId = $category->id;
        $type->price->price = '1000';
        $type->price->oldPrice = '900';
        \Yii::$app->session->set('_image_token', \Yii::$app->security->generateRandomString());
        $model = $this->service->create($type, $type->price);

        $this->tester->seeRecord(
            Product::class,
            [
                'id' => $model->id,
                'title' => $type->title,
                'announce' => $type->announce,
                'description' => $type->description,
                'status' => $type->status,
                'price' => $type->price->price,
                'brand_id' => $brand->id,
                'category_main_id' => $category->id,
                'old_price' => $type->price->oldPrice,
            ]
        );
    }
}