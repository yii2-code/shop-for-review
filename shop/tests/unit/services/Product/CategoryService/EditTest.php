<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 17:01
 */

namespace shop\tests\unit\services\Product\CategoryService;


use shop\entities\Product\Category;
use shop\types\Product\CategoryType;

/**
 * Class EditTest
 * @package shop\tests\unit\services\Product\CategoryService
 */
class EditTest extends Unit
{
    /**
     * @group product
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $category = $this->grabCategory(3);
        $type = new CategoryType();
        $type->title = 'Edit title';
        $type->description = 'Edit description';
        $type->status = Category::STATUS_DELETE;
        $model = $this->service->edit($category->id, $type);
        $this->tester->seeRecord(Category::class, ['id' => $model->id, 'title' => $type->title, 'description' => $type->description, 'status' => $type->status]);
    }
}