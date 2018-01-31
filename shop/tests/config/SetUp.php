<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 15:50
 */

namespace shop\tests\config;


use backend\modules\image\services\ImageManagerInterface;
use shop\tests\stubs\services\ImageManager;
use Yii;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = Yii::$container;

        $container->set(ImageManagerInterface::class, ImageManager::class);
    }

}