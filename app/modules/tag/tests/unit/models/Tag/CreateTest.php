<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 29.01.18
 * Time: 15:29
 */

namespace app\modules\tag\tests\unit\models\Tag;


use app\modules\tag\models\Tag;
use Codeception\Test\Unit;

/**
 * Class CreateTest
 * @package app\modules\tag\tests\unit\models\tag
 */
class CreateTest extends Unit
{

    /**
     * @group tag
     */
    public function testSuccess()
    {
        $model = Tag::create($name = 'name');
        $this->assertTrue($model->save(), 'unable to save model');
    }
}