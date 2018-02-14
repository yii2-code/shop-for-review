<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 14.02.18
 * Time: 20:15
 */

namespace common\fixtures;


use shop\entities\Product\Value;
use yii\test\ActiveFixture;

class ValueFixture extends ActiveFixture
{
    public function __construct(array $config = [])
    {
        $this->modelClass = Value::class;
        $this->dataFile = __DIR__ . '/data/value.php';
        parent::__construct($config);
    }

}