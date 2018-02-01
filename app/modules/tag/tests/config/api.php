<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 19:18
 */

$params = array_merge(
    require __DIR__ . '/../../../../../common/config/params.php',
    require __DIR__ . '/../../../../../common/config/params-local.php',
    require __DIR__ . '/../../../../../api/config/params.php'
);

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../../../../common/config/main.php',
    require __DIR__ . '/../../../../../common/config/main-local.php',
    require __DIR__ . '/../../../../../common/config/test.php',
    require __DIR__ . '/../../../../../common/config/test-local.php',
    require __DIR__ . '/../../../../../api/config/main.php',
    require __DIR__ . '/../../../../../api/config/test.php'
);


return $config;