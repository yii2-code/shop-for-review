<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 20:34
 */

namespace shop\helpers;


use shop\entities\Product\Characteristic;

/**
 * Class CharacteristicHelper
 * @package shop\helpers
 */
class CharacteristicHelper
{
    /**
     * @return array
     */
    public static function getTypeDropDown()
    {
        return [
            Characteristic::TYPE_STRING => 'String',
            Characteristic::TYPE_INTEGER => 'Integer',
            Characteristic::TYPE_FLOAT => 'Float',
        ];
    }

    /**
     * @return array
     */
    public static function getRequiredDropDown()
    {
        return [
            Characteristic::REQUIRED_NO => \Yii::t('yii', 'No'),
            Characteristic::REQUIRED_YES => \Yii::t('yii', 'Yes')
        ];
    }
}