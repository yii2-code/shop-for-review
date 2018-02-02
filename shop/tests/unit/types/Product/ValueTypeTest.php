<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 02.02.18
 * Time: 15:12
 */

namespace shop\tests\unit\types\Product;


use Codeception\Test\Unit;
use shop\entities\Product\Characteristic;
use shop\tests\fixtures\CharacteristicFixture;
use shop\tests\UnitTester;
use shop\types\Product\ValueType;

/**
 * Class ValueTypeTest
 * @package shop\tests\unit\types\Product
 */
class ValueTypeTest extends Unit
{
    /**
     * @var UnitTester
     */
    public $tester;

    /**
     * @group product
     */
    public function testStringSuccess()
    {
        $characteristic = $this->getCharacteristic(1);
        $type = new ValueType($characteristic);
        $type->value = 'test';
        $this->assertTrue($type->validate(), 'Unable to validate model');
    }

    /**
     * @group product
     */
    public function testNumberSuccess()
    {
        $characteristic = $this->getCharacteristic(3);
        $type = new ValueType($characteristic);
        $type->value = '111';
        $this->assertTrue($type->validate(), 'Unable to validate model');
    }

    /**
     * @group product
     */
    public function testNumberError()
    {
        $characteristic = $this->getCharacteristic(3);
        $type = new ValueType($characteristic);
        $type->value = 'test';
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('value', $type->getErrors(), 'Attribute "value" has not error');
    }

    /**
     * @group product
     */
    public function testFloatSuccess()
    {
        $characteristic = $this->getCharacteristic(4);
        $type = new ValueType($characteristic);
        $type->value = '111';
        $this->assertTrue($type->validate(), 'Unable to validate model');
    }

    /**
     * @group product
     */
    public function testFloatError()
    {
        $characteristic = $this->getCharacteristic(4);
        $type = new ValueType($characteristic);
        $type->value = 'test';
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('value', $type->getErrors(), 'Attribute "value" has not error');
    }

    /**
     * @group product
     */
    public function testRequired()
    {
        $characteristic = $this->getCharacteristic(2);
        $type = new ValueType($characteristic);
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('value', $type->getErrors(), 'Attribute "value" has not error');
    }


    /**
     * @param $index
     * @return Characteristic
     * @throws \shop\tests\_generated\ModuleException
     */
    public function getCharacteristic($index): Characteristic
    {
        $this->tester->haveFixtures([
            'characteristic' => CharacteristicFixture::class,
        ]);

        return $this->tester->grabFixture('characteristic', $index);
    }
}