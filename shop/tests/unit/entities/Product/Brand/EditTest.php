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
        Brand::deleteAll();
        $this->tester->have(Brand::class, ['id' => 1]);

        /** @var Brand $brand */
        $brand = $this->tester->grabRecord(Brand::class, ['id' => 1]);

        $brand->edit($title = 'title', $description = 'description', $status = Brand::STATUS_ACTIVE);
        $this->assertTrue($brand->save(), 'Unable to save model');
        $this->tester->seeRecord(Brand::class, ['id' => $brand->id, 'title' => $title, 'description' => $description, 'status' => $status]);
    }
}