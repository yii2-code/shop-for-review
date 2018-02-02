<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 19:08
 */

namespace shop\tests\unit\types\Product;


use Codeception\Test\Unit;
use shop\entities\Product\Characteristic;
use shop\entities\Product\Variant;
use shop\types\Product\CharacteristicType;

/**
 * Class CharacteristicTypeTest
 * @package shop\tests\unit\types\Product
 */
class CharacteristicTypeTest extends Unit
{
    /**
     * @group product
     */
    public function testSuccess()
    {
        $type = new CharacteristicType();
        $type->title = 'title';
        $type->type = Variant::TYPE_STRING;
        $type->required = Characteristic::REQUIRED_YES;
        $type->default = '200';
        $type->variants = [300, 400];

        $this->assertTrue($type->validate(), 'Unable to validate type');
    }

    /**
     * @group product
     */
    public function testRequired()
    {
        $type = new CharacteristicType();
        $this->assertFalse($type->validate(), 'Unable to validate type');
        $this->assertArrayHasKey('title', $type->getErrors(), 'Attribute has not "title" error');
        $this->assertArrayHasKey('type', $type->getErrors(), 'Attribute has not "type" error');
        $this->assertArrayHasKey('required', $type->getErrors(), 'Attribute has not "required" error');
    }
}