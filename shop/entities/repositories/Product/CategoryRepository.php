<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 23.01.18
 * Time: 22:55
 */

declare(strict_types=1);

namespace shop\entities\repositories\Product;


use shop\entities\Product\Category;
use yii\db\ActiveRecord;

/**
 * Class CategoryRepository
 * @package shop\entities\repositories\Product
 */
class CategoryRepository
{
    /**
     * @return Category|null|ActiveRecord
     */
    public function findOneRoot(): Category
    {
        return Category::find()->roots()->one();
    }

    /**
     * @param int $categoryId
     * @return null|Category
     */
    public function findOneById(int $categoryId): ?Category
    {
        return Category::find()->id($categoryId)->limit(1)->one();
    }
}