<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 06.02.18
 * Time: 20:55
 */

namespace app\modules\image\tests\unit\services\View;

/**
 * Class GetPlaceholderTest
 * @package app\modules\image\tests\unit\services\View
 */
class GetPlaceholderTest extends Unit
{

    /**
     * @group image
     */
    public function testSuccess()
    {
        is_file(codecept_output_dir('image/placeholder.png')) && unlink(codecept_output_dir('image/placeholder.png'));

        $url = $this->view->getPlaceholder();

        $this->assertEquals('/image/placeholder.png', $url);
        $this->assertFileExists(codecept_output_dir('image/placeholder.png'));
    }


}