<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 16:30
 */

namespace shop\tests\fixtures;


use shop\entities\Product\Characteristic;
use yii\test\ActiveFixture;


/**
 * Class CharacteristicFixture
 * @package shop\tests\fixtures
 */
class CharacteristicFixture extends ActiveFixture
{
    /**
     * CharacteristicFixture constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->modelClass = Characteristic::class;
        $this->dataFile = codecept_data_dir('characteristic.php');
        parent::__construct($config);
    }

}