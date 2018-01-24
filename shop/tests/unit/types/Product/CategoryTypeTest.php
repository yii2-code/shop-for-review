<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 14:30
 */

namespace shop\tests\unit\types\Product;


use Codeception\Test\Unit;
use shop\entities\Product\Category;
use shop\types\Product\CategoryType;

/**
 * Class CategoryTypeTest
 * @package shop\tests\unit\types\Product
 */
class CategoryTypeTest extends Unit
{

    /**
     * @group product
     */
    public function testSuccess()
    {
        $type = new CategoryType(new Category());;
        $type->title = 'Title';
        $type->description = 'description';
        $type->status = (string)Category::STATUS_ACTIVE;
        $this->assertTrue($type->validate(), 'Unable to validate type');
    }

    /**
     * @group product
     */
    public function testRequired()
    {
        $type = new CategoryType(new Category());;
        $this->assertFalse($type->validate(), 'Type is not validate');
        $this->assertArrayHasKey('title', $type->getErrors(), 'Property "title" has error');
        $this->assertArrayHasKey('description', $type->getErrors(), 'Property "description" has not error');
        $this->assertArrayHasKey('status', $type->getErrors(), 'Property "status" has not error');
    }


    /**
     * @group product
     */
    public function testExist()
    {
        $type = new CategoryType(new Category());;
        $type->categoryId = 2;
        $this->assertFalse($type->validate(), 'Type is not validate');
        $this->assertArrayHasKey('categoryId', $type->getErrors(), 'Property "categoryId" has not error');
    }
}