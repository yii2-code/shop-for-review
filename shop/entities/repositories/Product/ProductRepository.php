<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 18:47
 */

declare(strict_types=1);

namespace shop\entities\repositories\Product;


use shop\entities\Product\Product;

/**
 * Class ProductRepository
 * @package shop\entities\repositories\Product
 */
class ProductRepository
{
    /**
     * @param int $id
     * @return null|Product
     */
    public function findOne(int $id): ?Product
    {
        return Product::find()->id($id)->limit(1)->one();
    }
}