<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 17.01.18
 * Time: 20:02
 */

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../../common/config/main.php',
    require __DIR__ . '/../../../common/config/main-local.php',
    require __DIR__ . '/../../../backend/config/main.php',
    require __DIR__ . '/../../../backend/config/main-local.php'
);

return $config;