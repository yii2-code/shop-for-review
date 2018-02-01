<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 16:29
 */

namespace shop\tests\unit\entities\Product\Characteristic;


use Codeception\Test\Unit;
use shop\entities\Product\Characteristic;
use shop\tests\fixtures\CharacteristicFixture;
use shop\tests\UnitTester;

/**
 * Class EditTest
 * @package shop\tests\unit\entities\Product\Characteristic
 */
class EditTest extends Unit
{

    /** @var UnitTester */
    protected $tester;

    /**
     * @group product
     */
    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'characteristic' => CharacteristicFixture::class,
        ]);

        /** @var Characteristic $characteristic */
        $characteristic = $this->tester->grabFixture('characteristic', 1);

        $characteristic->edit(
            $title = 'Title',
            $type = Characteristic::TYPE_INTEGER,
            $required = Characteristic::REQUIRED_YES,
            $default = 2,
            $variants = [3, 4]
        );

        $this->assertTrue($characteristic->save(), 'Unable to save model');

        $this->tester->seeRecord(
            Characteristic::class,
            [
                'id' => $characteristic->id,
                'title' => $title,
                'type' => $type,
                'required' => $required,
                'default' => $default,
            ]
        );
    }
}