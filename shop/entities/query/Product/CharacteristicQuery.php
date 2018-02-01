<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 16:25
 */

declare(strict_types=1);

namespace shop\entities\query\Product;


use shop\entities\Product\Characteristic;
use yii\db\ActiveQuery;

/**
 * Class CharacteristicQuery
 * @package shop\entities\query\Product
 */
class CharacteristicQuery extends ActiveQuery
{

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]|Characteristic[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord|Characteristic
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param int $id
     * @return CharacteristicQuery
     */
    public function id(int $id): self
    {
        return $this->andWhere([Characteristic::tableName() . '.[[id]]' => $id]);
    }
}