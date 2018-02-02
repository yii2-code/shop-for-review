<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 02.02.18
 * Time: 13:53
 */

namespace shop\tests\unit\entities\Product\Value;


use Codeception\Test\Unit;
use shop\entities\Product\Characteristic;
use shop\entities\Product\Product;
use shop\entities\Product\Value;
use shop\tests\fixtures\CharacteristicFixture;
use shop\tests\fixtures\ProductFixture;
use shop\tests\UnitTester;

/**
 * Class CreateTest
 * @package shop\tests\unit\entities\Product\Value
 */
class CreateTest extends Unit
{
    /** @var UnitTester */
    public $tester;

    /**
     * @group product
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'characteristic' => CharacteristicFixture::class,
            'product' => ProductFixture::class,
        ]);

        /** @var Characteristic $characteristic */
        $characteristic = $this->tester->grabFixture('characteristic', 2);

        /** @var Product $product */
        $product = $this->tester->grabFixture('product', 1);

        $value = Value::create($product->id, $characteristic->id, $value = 'value');
        $this->assertTrue($value->save(), 'Unable to save model');

        $this->tester->seeRecord(Value::class, [
            'id' => $value->id,
            'product_id' => $product->id,
            'characteristic_id' => $characteristic->id,
            'value' => $value,
        ]);

        $this->assertTrue((bool)$value->delete(), 'Unable to delete model');
    }
}