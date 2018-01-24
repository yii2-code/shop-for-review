<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 16:08
 */

namespace shop\tests\unit\services\Product\CategoryService;


use shop\entities\Product\Category;
use shop\types\Product\CategoryType;

/**
 * Class CreateTest
 * @package shop\tests\unit\services\Product\CategoryService
 */
class CreateTest extends Unit
{

    /**
     * @group product
     */
    public function testSuccess()
    {
        $root = $this->grabCategory(2);

        $type = new CategoryType();
        $type->title = 'Title';
        $type->description = 'Description';
        $type->status = Category::STATUS_ACTIVE;
        $type->categoryId = $root->id;
        $this->assertTrue($type->validate(), 'Unable to validate type');
        $model = $this->service->create($type);
        $this->tester->seeRecord(Category::class, ['id' => $model->id, 'title' => $type->title, 'description' => $type->description, 'status' => $type->status]);
    }
}