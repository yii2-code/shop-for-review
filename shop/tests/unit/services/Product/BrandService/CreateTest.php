<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 12:33
 */

namespace shop\tests\unit\services\Product\BrandService;


use shop\entities\Product\Brand;

/**
 * Class CreateTest
 * @package shop\tests\unit\services\Product\BrandService
 */
class CreateTest extends Unit
{

    /**
     * @group product
     */
    public function testSuccess()
    {
        $type = $this->service->createType();
        $type->title = 'title';
        $type->description = 'description';
        $type->status = Brand::STATUS_ACTIVE;
        $model = $this->service->create($type);
        $this->tester->seeRecord(Brand::class, ['id' => $model->id, 'title' => $type->title, 'description' => $type->description, 'status' => $type->status]);
    }
}