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
use Yii;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = Yii::$container;

        $container->set('image', function () use ($container) {
            return new ImageManager(
                new ImageRepository(),
                codecept_output_dir() . '/image',
                '/image',
                '_identity-image'
            );
        });
    }

}