<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 14:38
 */

namespace backend\modules\image\tests\config;


use backend\modules\image\models\ImageRepository;
use backend\modules\image\services\ImageManager;
use backend\modules\image\services\ImageManagerInterface;
use Yii;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = Yii::$container;

        $container->set(ImageManagerInterface::class, function () use ($container) {
            return new ImageManager(
                new ImageRepository(),
                codecept_output_dir() . 'image',
                '/image',
                codecept_output_dir() . 'image/thumb',
                '/image/thumb',
                '_identity-image'
            );
        });
    }

}