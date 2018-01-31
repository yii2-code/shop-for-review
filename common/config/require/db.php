<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 17.01.18
 * Time: 18:53
 */


return [
    'class' => yii\db\Connection::class,
    'dsn' => sprintf('mysql:host=%s;dbname=%s', getenv('MYSQL_HOST'), getenv('MYSQL_DATABASE')),
    'username' => getenv('MYSQL_USERNAME'),
    'password' => getenv('MYSQL_PASSWORD'),
    'charset' => 'utf8',
    'tablePrefix' => 'shop_',
    'enableQueryCache' => true,
    'queryCacheDuration' => 1 * 60 * 60,
    'enableSchemaCache' => YII_ENV_PROD,
    'schemaCacheDuration' => 1 * 60 * 60,
];