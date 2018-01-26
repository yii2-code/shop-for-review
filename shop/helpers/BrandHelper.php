<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 15:11
 */

declare(strict_types=1);

namespace shop\helpers;


use shop\entities\Product\Brand;
use Yii;

/**
 * Class BrandHelper
 * @package shop\helpers
 */
class BrandHelper
{
    /**
     * @return array
     */
    public static function getStatusDropDown(): array
    {
        return [
            Brand::STATUS_ACTIVE => Yii::t('shop', 'Active'),
            Brand::STATUS_DELETE => Yii::t('shop', 'Delete'),
        ];
    }

    /**
     * @return array
     */
    public static function getDropDown(): array
    {
        return Brand::find()->select(['title', 'id'])->indexBy('id')->column();
    }
}