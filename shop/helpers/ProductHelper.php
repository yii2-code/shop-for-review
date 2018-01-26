<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 14:10
 */

namespace shop\helpers;


use shop\entities\Product\Product;

/**
 * Class ProductHelper
 * @package shop\helpers
 */
class ProductHelper
{
    /**
     * @return array
     */
    public static function getStatusDropDown()
    {
        return [
            Product::STATUS_ACTIVE => 'Active',
            Product::STATUS_DELETE => 'Delete',
        ];
    }
}