<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 16:25
 */

namespace shop\tests\unit\entities\Product\Category;


use Codeception\Test\Unit;
use shop\entities\Product\Category;
use shop\tests\fixtures\CategoryFixture;
use shop\tests\UnitTester;

/**
 * Class EditTest
 * @package shop\tests\unit\entities\Product\Category
 */
class EditTest extends Unit
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @group product
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'category' => [
                'class' => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . '/category.php'
            ]
        ]);

        /** @var $category2 Category */
        $category2 = $this->tester->grabFixture('category', 2);
        $category2->edit($title = 'Edit title', $description = 'Edit description', $status = Category::STATUS_DELETE);

        /** @var $category3 Category */
        $category3 = $this->tester->grabFixture('category', 3);
        $category2->appendTo($category3);

        $this->assertTrue($category2->save(), 'Unable to save model');
    }
}