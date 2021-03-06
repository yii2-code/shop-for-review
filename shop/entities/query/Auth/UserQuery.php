<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 17.01.18
 * Time: 19:41
 */

declare(strict_types=1);

namespace shop\entities\query\Auth;

use shop\entities\Auth\User;
use yii\db\ActiveQuery;

/**
 * Class UserQuery
 * @package shop\entities\query\Auth
 */
class UserQuery extends ActiveQuery
{
    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord|User
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]|User[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param int $id
     * @return UserQuery
     */
    public function id(int $id): self
    {
        return $this->andWhere([User::tableName() . '.[[id]]' => $id]);
    }

    /**
     * @param string $email
     * @return UserQuery
     */
    public function email(string $email): self
    {
        return $this->andWhere([User::tableName() . '.[[email]]' => $email]);
    }

    /**
     * @param string $login
     * @return UserQuery
     */
    public function login(string $login): self
    {
        return $this->andWhere([User::tableName() . '.[[login]]' => $login]);
    }

    /**
     * @param string $token
     * @return UserQuery
     */
    public function emailActive(string $token): self
    {
        return $this->andWhere([User::tableName() . '.[[email_active_token]]' => $token]);
    }


    /**
     * @param string $token
     * @return UserQuery
     */
    public function passwordReset(string $token): self
    {
        return $this->andWhere([User::tableName() . '.[[password_reset_token]]' => $token]);
    }
}