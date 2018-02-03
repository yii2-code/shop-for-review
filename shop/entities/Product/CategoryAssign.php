<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 03.02.18
 * Time: 15:41
 */

namespace shop\entities\Product;

use DomainException;
use shop\entities\repositories\Product\CategoryRepository;
use shop\entities\repositories\Product\ProductRepository;
use yii\db\ActiveRecord;


/**
 * Class CategoryAssign
 * @package shop\entities\Product
 * @property $id int
 * @property $product_id int
 * @property $category_id int
 */
class CategoryAssign extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%category_assign}}';
    }

    /**
     * @param int $productId
     * @param int $categoryId
     * @return static
     */
    public static function create(int $productId, int $categoryId)
    {
        $productRepository = new ProductRepository();
        $categoryRepository = new CategoryRepository();

        if (!$productRepository->existsById($productId)) {
            throw new DomainException('Unable to create model because product not found');
        }

        if (!$categoryRepository->existsById($categoryId)) {
            throw new DomainException('Unable to create model because category not found');
        }

        $model = new static();
        $model->product_id = $productId;
        $model->category_id = $categoryId;
        return $model;
    }
}