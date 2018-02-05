<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 05.02.18
 * Time: 19:01
 */

namespace shop\entities\query\Auth;


use shop\entities\Auth\Profile;
use yii\db\ActiveQuery;

/**
 * Class ProfileQuery
 * @package shop\entities\query\Auth
 */
class ProfileQuery extends ActiveQuery
{
    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord|Profile
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]|Profile[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param int $id
     * @return ProfileQuery
     */
    public function id(int $id): self
    {
        return $this->andWhere([Profile::tableName() . '.[[id]]' => $id]);
    }
}