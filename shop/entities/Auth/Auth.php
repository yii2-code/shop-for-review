<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 22.01.18
 * Time: 17:22
 */

declare(strict_types=1);

namespace shop\entities\Auth;

use DomainException;
use shop\entities\query\Auth\AuthQuery;
use shop\entities\repositories\Auth\UserRepository;
use yii\db\ActiveRecord;
use yii\di\Instance;


/**
 * Class Auth
 * @package shop\entities\Auth
 * @property $id int
 * @property $user_id int
 * @property $source string
 * @property $source_id string
 *
 * @property $user User
 */
class Auth extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%auth}}';
    }

    /**
     * @param int $userId
     * @param string $source
     * @param string $sourceId
     * @return Auth
     * @throws \yii\base\InvalidConfigException
     */
    public static function create(
        int $userId,
        string $source,
        string $sourceId
    ): self
    {
        $model = new static();
        $model->setUserId($userId);
        $model->source = $source;
        $model->source_id = $sourceId;

        return $model;
    }

    /**
     * @param int $id
     * @throws \yii\base\InvalidConfigException
     */
    public function setUserId(int $id)
    {
        /** @var UserRepository $repository */
        $repository = Instance::ensure(UserRepository::class);

        if (!$repository->existsById($id)) {
            throw new DomainException('Incorrectly user');
        }
        $this->user_id = $id;
    }

    /**
     * @return AuthQuery|\yii\db\ActiveQuery
     */
    public static function find(): AuthQuery
    {
        return new AuthQuery(static::class);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}