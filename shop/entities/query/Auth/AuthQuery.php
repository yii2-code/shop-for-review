<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 22.01.18
 * Time: 19:39
 */

namespace shop\entities\query\Auth;


use shop\entities\Auth\Auth;
use yii\db\ActiveQuery;

/**
 * Class AuthQuery
 * @package shop\entities\query\Auth
 */
class AuthQuery extends ActiveQuery
{
    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord|Auth
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]|Auth[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param string $source
     * @return AuthQuery
     */
    public function source(string $source): self
    {
        return $this->andWhere([Auth::tableName() . '.[[source]]' => $source]);
    }

    /**
     * @param string $sourceId
     * @return AuthQuery
     */
    public function sourceId(string $sourceId): self
    {
        return $this->andWhere([Auth::tableName() . '.[[source_id]]' => $sourceId]);
    }
}