<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 23.01.18
 * Time: 22:46
 */

namespace shop\entities\query\Product;


use paulzi\nestedsets\NestedSetsQueryTrait;
use shop\entities\Product\Category;
use yii\db\ActiveQuery;

/**
 * Class CategoryQuery
 * @package shop\entities\query\Product
 */
class CategoryQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;


    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord|Category
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]|Category[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param int $id
     * @return CategoryQuery
     */
    public function id(int $id): self
    {
        return $this->andWhere([Category::tableName() . '.[[id]]' => $id]);
    }


    /**
     * @return CategoryQuery
     */
    public function notRoot(): self
    {
        return $this->andWhere(['NOT', [Category::tableName() . '.[[depth]]' => Category::DEPTH_ROOT]]);
    }
}