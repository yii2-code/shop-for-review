<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 02.02.18
 * Time: 13:45
 */

declare(strict_types=1);

namespace shop\entities\repositories\Product;

use shop\entities\Product\Value;

/**
 * Class ValueRepository
 * @package shop\entities\repositories\Product
 */
class ValueRepository
{
    /**
     * @param int $id
     * @return null|Value
     */
    public function findOne(int $id): ?Value
    {
        return Value::find()->id($id)->limit(1)->one();
    }
}