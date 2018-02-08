<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 18:44
 */

declare(strict_types=1);

namespace shop\entities\query\Product;


use shop\entities\Product\Product;
use yii\db\ActiveQuery;

/**
 * Class ProductQuery
 * @package shop\entities\query\Product
 */
class ProductQuery extends ActiveQuery
{
    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]|Product[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord|Product
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param int $id
     * @return ProductQuery
     */
    public function id(int $id): self
    {
        return $this->andWhere([Product::tableName() . '.[[id]]' => $id]);
    }

    /**
     * @return ProductQuery
     */
    public function active(): self
    {
        return $this->andWhere([Product::tableName() . '.[[status]]' => Product::STATUS_ACTIVE]);
    }

    /**
     * @param int[] $ids
     * @return ProductQuery
     */
    public function inCategoryMain(array $ids): self
    {
        return $this->andWhere(['IN', Product::tableName() . '.[[category_main_id]]', $ids]);
    }
}