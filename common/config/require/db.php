<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 17.01.18
 * Time: 18:53
 */

return [
    'class' => yii\db\Connection::class,
    'dsn' => 'mysql:host=172.73.251.4;dbname=shop',
    'username' => 'shop',
    'password' => 'shop',
    'charset' => 'utf8',
    'tablePrefix' => 'shop_',
    'enableQueryCache' => true,
    'queryCacheDuration' => 1 * 60 * 60,
    'enableSchemaCache' => YII_ENV_PROD,
    'schemaCacheDuration' => 1 * 60 * 60,
];