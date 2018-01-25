<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 22:55
 */

declare(strict_types=1);

namespace shop\entities\repositories\Product;

use shop\entities\Product\Brand;

/**
 * Class BrandRepository
 * @package shop\entities\repositories\Product
 */
class BrandRepository
{
    /**
     * @param int $id
     * @return null|Brand
     */
    public function findOne(int $id): ?Brand
    {
        return Brand::find()->id($id)->limit(1)->one();
    }
}