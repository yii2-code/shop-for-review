<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 19:18
 */

$params = array_merge(
    require __DIR__ . '/../../../../../common/config/params.php'
);

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../../../../common/config/main.php',
    require __DIR__ . '/../../../../../common/config/test.php',
    [
        'bootstrap' => [\app\modules\image\tests\config\SetUp::class],
        'language' => 'en-US',
        'params' => $params
    ]
);

return $config;