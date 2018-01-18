<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 17.01.18
 * Time: 19:35
 */

declare(strict_types=1);

namespace Shop\entities\Auth;


use shop\entities\query\Auth\UserQuery;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package shop\entities\Auth
 * @property $id integer
 * @property $status integer
 * @property $login string
 * @property $password string
 * @property $email string
 * @property $request_email_token string
 * @property $created_at string
 * @property $updated_at string
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_CONFIRM_EMAIL = 3;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return UserQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new UserQuery(static::class);
    }


    /**
     * @param string $password
     * @param string $login
     * @param string $email
     * @return User
     * @throws \yii\base\Exception
     */
    public static function requestSignup(
        string $password,
        string $login,
        string $email
    ): self
    {
        $model = new static();
        $model->login = $login;
        $model->email = $email;
        $model->status = static::STATUS_CONFIRM_EMAIL;
        $model->generateResetEmailToken();
        $model->setPassword($password);
        return $model;
    }


    /**
     * @throws \yii\base\Exception
     * @return void
     */
    public function generateResetEmailToken(): void
    {
        $this->request_email_token = Yii::$app->security->generateRandomString(64);
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }


    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * @param int|string $id
     * @return UserQuery|IdentityInterface
     */
    public static function findIdentity($id)
    {
        return User::find()->id($id);
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }


    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}