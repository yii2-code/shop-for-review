<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 16:27
 */

declare(strict_types=1);

namespace shop\entities\repositories\Product;

use shop\entities\Product\Characteristic;

/**
 * Class CharacteristicRepository
 * @package shop\entities\repositories\Product
 */
class CharacteristicRepository
{
    /**
     * @return int
     */
    public function maxPosition(): int
    {
        return (int)Characteristic::find()->max('position');
    }

    /**
     * @param $id
     * @return null|Characteristic
     */
    public function findOne($id): ?Characteristic
    {
        return Characteristic::find()->id($id)->limit(1)->one();
    }
}