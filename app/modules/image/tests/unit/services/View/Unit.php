<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 06.02.18
 * Time: 22:15
 */

namespace app\modules\image\tests\unit\services\View;


use app\modules\image\services\Config;
use app\modules\image\services\Upload;
use app\modules\image\services\View;
use app\modules\image\tests\UnitTester;
use Yii;

class Unit extends \Codeception\Test\Unit
{
    /** @var UnitTester */
    public $tester;
    /**
     * @var View
     */
    public $view;

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
            [
                '640x640' => [
                    'weight' => 640,
                    'height' => 640,
                    'quality' => 100,
                ]
            ],
            Yii::getAlias('@app/modules/image/data/placeholder.png')
        );
        $this->view = new View($config, new Upload($config));
    }
}