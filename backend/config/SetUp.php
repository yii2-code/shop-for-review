<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 16:04
 */

namespace backend\config;


use Yii;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = Yii::$container;
    }

}