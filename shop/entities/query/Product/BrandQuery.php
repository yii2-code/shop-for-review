<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 22:47
 */

declare(strict_types=1);

namespace shop\entities\query\Product;


use shop\entities\Product\Brand;
use yii\db\ActiveQuery;

/**
 * Class BrandQuery
 * @package shop\entities\query\Product
 */
class BrandQuery extends ActiveQuery
{

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]|Brand[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }


    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord|Brand
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    /**
     * @param int $id
     * @return BrandQuery
     */
    public function id(int $id): self
    {
        return $this->andWhere([Brand::tableName() . '.[[id]]' => $id]);
    }
}