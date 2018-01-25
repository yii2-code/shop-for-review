<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 12:13
 */

namespace shop\tests\unit\entities\Product\Brand;


use Codeception\Test\Unit;
use shop\entities\Product\Brand;
use shop\tests\UnitTester;

/**
 * Class CreateTest
 * @package shop\tests\unit\entities\Product\Brand
 */
class CreateTest extends Unit
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @group product
     */
    public function testSuccess()
    {
        $model = Brand::create($title = 'title', $description = 'description', $status = Brand::STATUS_ACTIVE);
        $this->assertTrue($model->save(), 'Unable to save model');
        $this->tester->seeRecord(Brand::class, ['id' => $model->id, 'title' => $title, 'description' => $description, 'status' => $status]);
    }
}