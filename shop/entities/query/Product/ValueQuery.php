<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 02.02.18
 * Time: 13:43
 */

declare(strict_types=1);

namespace shop\entities\query\Product;

use shop\entities\Product\Value;
use yii\db\ActiveQuery;

/**
 * Class ValueQuery
 * @package shop\entities\query\Product
 */
class ValueQuery extends ActiveQuery
{
    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord|Value
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]|Value[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param int $id
     * @return self
     */
    public function id(int $id): self
    {
        return $this->andWhere([Value::tableName() . '.[[id]]' => $id]);
    }

    /**
     * @param int $id
     * @return self
     */
    public function product(int $id): self
    {
        return $this->andWhere([Value::tableName() . '.[[product_id]]' => $id]);
    }

    /**
     * @param int $id
     * @return self
     */
    public function characteristic(int $id): self
    {
        return $this->andWhere([Value::tableName() . '.[[characteristic_id]]' => $id]);
    }
}