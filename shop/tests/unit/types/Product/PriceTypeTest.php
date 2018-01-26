<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 22:21
 */

namespace shop\tests\unit\types\Product;


use Codeception\Test\Unit;
use shop\types\Product\PriceType;

/**
 * Class PriceTypeTest
 * @package shop\tests\unit\types\Product
 */
class PriceTypeTest extends Unit
{
    /**
     * @group product
     */
    public function testSuccess()
    {
        $type = new PriceType();
        $type->price = '1000';
        $type->oldPrice = '2000';

        $this->assertTrue($type->validate(), 'Unable to validate type');
    }

    /**
     * @group product
     */
    public function testRequired()
    {
        $type = new PriceType();
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('price', $type->getErrors(), 'Property has not error');
    }
}