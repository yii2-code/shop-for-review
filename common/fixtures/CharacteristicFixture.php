<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 14.02.18
 * Time: 20:03
 */

namespace common\fixtures;


use shop\entities\Product\Characteristic;
use yii\test\ActiveFixture;

class CharacteristicFixture extends ActiveFixture
{
    public function __construct(array $config = [])
    {
        $this->modelClass = Characteristic::class;
        $this->dataFile = __DIR__ . '/data/characteristic.php';
        parent::__construct($config);
    }
}