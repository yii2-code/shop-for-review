<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 13:09
 */

namespace shop\tests\unit\services\Product\BrandService;


use shop\entities\Product\Brand;

/**
 * Class EditTest
 * @package shop\tests\unit\services\Product\BrandService
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
        $brand = $this->grabBrand(1);

        $type = $this->service->createType();
        $type->title = 'title';
        $type->description = 'description';
        $type->status = Brand::STATUS_ACTIVE;
        $this->service->edit($brand->id, $type);
        $this->tester->seeRecord(Brand::class, ['id' => $brand->id, 'title' => $type->title, 'description' => $type->description, 'status' => $type->status]);
    }
}