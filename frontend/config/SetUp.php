<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 21:10
 */

namespace frontend\config;


use shop\services\Auth\UserService;
use Yii;
use yii\base\BootstrapInterface;
use yii\di\Instance;
use yii\swiftmailer\Mailer;

/**
 * Class SetUp
 * @package frontend\config
 */
class SetUp implements BootstrapInterface
{
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $container = Yii::$container;
        $container->set('mailerShop', function () use ($app) {
            /** @var $mailer Mailer */
            $mailer = $app->mailer;
            $mailer->viewPath = '@shop/mail';
            $mailer->messageConfig = [
                'from' => $app->params['adminEmail'],
            ];

            return $mailer;
        });

        $container->set(UserService::class, [], [1 => Instance::of('mailerShop')]);
    }
}