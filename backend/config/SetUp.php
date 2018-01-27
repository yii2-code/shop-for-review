<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 16:04
 */

namespace backend\config;


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
                Yii::getAlias('@static/image'),
                'http://static.shop.app/image',
                '_identity-image',
                20
            );
        });
    }

}