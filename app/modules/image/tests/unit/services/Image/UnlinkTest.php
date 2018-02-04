<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 04.02.18
 * Time: 19:39
 */

namespace app\modules\image\tests\unit\services\Image;


/**
 * Class UnlinkTest
 * @package app\modules\image\tests\unit\services\Image
 */
class UnlinkTest extends Unit
{
    /**
     * @group image
     */
    public function testSuccess()
    {
        $src = '650x650.png';
        $thumb = '160x160';
        copy(codecept_data_dir($src), codecept_output_dir("image/$src"));
        copy(codecept_data_dir($src), codecept_output_dir("image/thumb/$thumb-$src"));

        $this->service->unlink($src);

        $this->assertFileNotExists(codecept_output_dir("image/$src"));
        $this->assertFileNotExists(codecept_output_dir("image/thumb/$thumb-$src"));
    }
}