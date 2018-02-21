<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 22:09
 */

namespace common\config;


use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Yii;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = Yii::$container;
        $container->set(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->set(Client::class, function () {
            return ClientBuilder::create()->setHosts([getenv('ELASTICSEARCH_HOST')])->build();
        });
    }

}