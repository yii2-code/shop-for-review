<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 23:20
 */

namespace shop\tests\unit\types\Product;


use Codeception\Test\Unit;
use shop\entities\Product\Brand;
use shop\entities\Product\Category;
use shop\entities\Product\Product;
use shop\tests\fixtures\BrandFixture;
use shop\tests\fixtures\CategoryFixture;
use shop\tests\UnitTester;
use shop\types\Product\ProductEditType;

class ProductEditTypeTest extends Unit
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

        $type = new ProductEditType(new Product());
        $type->title = 'Title';
        $type->announce = 'Announce';
        $type->description = 'Description';
        $type->status = Product::STATUS_ACTIVE;
        $type->brandId = $brand->id;
        $type->categoryMainId = $category->id;
        $this->assertTrue($type->validate(), 'Unable to validate type');
    }

    /**
     * @group product
     */
    public function testRequired()
    {
        $type = new ProductEditType(new Product());
        $this->assertFalse($type->validate());

        $this->assertArrayHasKey('title', $type->getErrors(), 'Property "title" has not error');
        $this->assertArrayHasKey('announce', $type->getErrors(), 'Property "announce" has not error');
        $this->assertArrayHasKey('description', $type->getErrors(), 'Property "description" has not error');
        $this->assertArrayHasKey('brandId', $type->getErrors(), 'Property "brandId" has not error');
        $this->assertArrayHasKey('categoryMainId', $type->getErrors(), 'Property "categoryMainId" has not error');
    }

    /**
     * @group product
     */
    public function testExists()
    {
        $type = new ProductEditType(new Product());
        $type->brandId = 1;
        $type->categoryMainId = 1;
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('brandId', $type->getErrors(), 'Property "brandId" has not error');
        $this->assertArrayHasKey('categoryMainId', $type->getErrors(), 'Property "categoryMainId" has not error');
    }
}