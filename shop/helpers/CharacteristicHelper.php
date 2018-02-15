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
    public static function getRequiredDropDown()
    {
        return [
            Characteristic::REQUIRED_NO => \Yii::t('yii', 'No'),
            Characteristic::REQUIRED_YES => \Yii::t('yii', 'Yes')
        ];
    }

    /**
     * @param Characteristic $characteristic
     * @return array
     */
    public static function getVariantsDropDown(Characteristic $characteristic): array
    {
        $list = array_combine($characteristic->variants, $characteristic->variants);
        if (!is_null($characteristic->default)) {
            $list = [$characteristic->default => $characteristic->default] + $list;
        }
        return $list;
    }
}