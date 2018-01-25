<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 12:17
 */

namespace shop\tests\unit\entities\Product\Brand;


use Codeception\Test\Unit;
use shop\entities\Product\Brand;
use shop\tests\fixtures\BrandFixture;
use shop\tests\UnitTester;

/**
 * Class EditTest
 * @package shop\tests\unit\entities\Product\Brand
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
            'brand' => [
                'class' => BrandFixture::class,
                'dataFile' => codecept_data_dir() . '/brand.php',
            ]
        ]);

        /** @var Brand $brand */
        $brand = $this->tester->grabFixture('brand', 1);

        $brand->edit($title = 'title', $description = 'description', $status = Brand::STATUS_ACTIVE);
        $this->assertTrue($brand->save(), 'Unable to save model');
        $this->tester->seeRecord(Brand::class, ['id' => $brand->id, 'title' => $title, 'description' => $description, 'status' => $status]);
    }
}