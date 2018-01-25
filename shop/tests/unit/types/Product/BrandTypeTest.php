<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 12:05
 */

namespace shop\tests\unit\types\Product;


use Codeception\Test\Unit;
use shop\entities\Product\Brand;
use shop\types\Product\BrandType;

/**
 * Class BrandTypeTest
 * @package shop\tests\unit\types\Product
 */
class BrandTypeTest extends Unit
{
    /**
     * @group product
     */
    public function testSuccess()
    {
        $type = new BrandType();
        $type->title = 'title';
        $type->description = 'description';
        $type->status = Brand::STATUS_ACTIVE;
        $this->assertTrue($type->validate(), 'Unable to validate type');
    }

    /**
     * @group product
     */
    public function testRequired()
    {
        $type = new BrandType();
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('title', $type->getErrors(), 'Property "title" has not error');
        $this->assertArrayHasKey('description', $type->getErrors(), 'Property "description" has not error');
        $this->assertArrayHasKey('status', $type->getErrors(), 'Property "status" has not error');
    }

    /**
     * @group product
     */
    public function testIntval()
    {
        $type = new BrandType();
        $type->status = Brand::STATUS_ACTIVE;
        $this->assertFalse($type->validate());
        $this->assertInternalType('integer', $type->status);
    }
}