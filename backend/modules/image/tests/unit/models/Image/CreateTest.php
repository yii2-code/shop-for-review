<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 19:23
 */

namespace backend\modules\image\tests\unit\models\Image;


use backend\modules\image\models\Image;
use Codeception\Test\Unit;

/**
 * Class CreateTest
 * @package backend\modules\image\tests\unit\models\Image
 */
class CreateTest extends Unit
{
    /**
     * @group image
     */
    public function testSuccess()
    {
        $model = Image::create($name = 'name', $src = 'src', $class = static::class, $position = 2);

        $this->assertEquals($name, $model->name);
        $this->assertEquals($src, $model->src);
        $this->assertEquals($class, $model->class);
        $this->assertEquals($position, $model->position);
        $this->assertNull($model->main);
    }
}