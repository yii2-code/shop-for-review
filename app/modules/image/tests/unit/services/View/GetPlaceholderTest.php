<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 06.02.18
 * Time: 20:55
 */

namespace app\modules\image\tests\unit\services\View;


use app\modules\image\services\Config;
use app\modules\image\services\Upload;
use app\modules\image\services\View;
use app\modules\image\tests\UnitTester;
use Codeception\Test\Unit;

/**
 * Class GetPlaceholderTest
 * @package app\modules\image\tests\unit\services\View
 */
class GetPlaceholderTest extends Unit
{
    /** @var UnitTester */
    public $tester;

    /**
     * @var View
     */
    public $view;


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

    /**
     *
     */
    protected function _before()
    {
        $config = new Config(
            codecept_output_dir('image'),
            codecept_output_dir('image/thumb'),
            '/image',
            '/image/thumb',
            [],
            \Yii::getAlias('@app/modules/image/data/placeholder.png')
        );
        $this->view = new View($config, new Upload($config));
    }
}