<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 06.02.18
 * Time: 22:23
 */

namespace app\modules\image\tests\unit\services\View;


/**
 * Class GetThumbPlaceholderTest
 * @package app\modules\image\tests\unit\services\View
 */
class GetThumbPlaceholderTest extends Unit
{
    /**
     * @group image
     */
    public function testSuccess()
    {
        is_file(codecept_output_dir('image/thumb/640x640-placeholder.png')) && unlink(codecept_output_dir('image/thumb/640x640-placeholder.png'));

        $url = $this->view->getThumbPlaceholder('640x640');

        $this->assertEquals('/image/thumb/640x640-placeholder.png', $url);
        $this->assertFileExists(codecept_output_dir('image/thumb/640x640-placeholder.png'));
    }
}