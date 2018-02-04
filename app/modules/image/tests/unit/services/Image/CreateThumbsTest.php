<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 04.02.18
 * Time: 19:19
 */

namespace app\modules\image\tests\unit\services\Image;


/**
 * Class CreateThumbsTest
 * @package app\modules\image\tests\unit\services\Image
 */
class CreateThumbsTest extends Unit
{
    /**
     * @group image
     */
    public function testSuccess()
    {
        $src = '650x650.png';
        $thumb = '160x160';
        copy(codecept_data_dir($src), codecept_output_dir("image/$src"));
        $this->service->createThumbs($src);
        $this->assertFileExists(codecept_output_dir("image/thumb/$thumb-$src"));
    }
}