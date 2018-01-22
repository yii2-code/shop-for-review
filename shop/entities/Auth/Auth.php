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
use shop\entities\repositories\UserRepository;
use yii\db\ActiveRecord;


/**
 * Class Auth
 * @package shop\entities\Auth
 * @property $id int
 * @property $user_id int
 * @property $source string
 * @property $source_id string
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
     */
    public function setUserId(int $id)
    {
        $repository = new UserRepository();

        if (!$repository->existsById($id)) {
            throw new DomainException('Incorrectly user');
        }
        $this->user_id = $id;
    }
}