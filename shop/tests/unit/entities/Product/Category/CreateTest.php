<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 13:33
 */

namespace shop\tests\unit\entities\Product\Category;


use Codeception\Test\Unit;
use shop\entities\Product\Category;
use shop\entities\repositories\Product\CategoryRepository;
use shop\tests\fixtures\CategoryFixture;
use shop\tests\UnitTester;

class CreateTest extends Unit
{
    /** @var UnitTester */
    public $tester;

    /**
     * @group product
     */
    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'category' => [
                'class' => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . '/category.php'
            ]
        ]);

        $category = Category::create($title = 'Title', $description = 'Description', $status = Category::STATUS_ACTIVE);
        $root = (new CategoryRepository())->findOneRoot();
        $category->appendTo($root);
        $this->assertTrue($category->save(), 'Unable to save model');
        $this->tester->seeRecord(Category::class, ['title' => $title, 'description' => $description, 'status' => $status]);
    }
}