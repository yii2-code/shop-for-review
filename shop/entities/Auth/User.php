<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 17.01.18
 * Time: 19:35
 */

declare(strict_types=1);

namespace shop\entities\Auth;

use app\behaviors\TimestampBehavior;
use DomainException;
use shop\entities\query\Auth\UserQuery;
use shop\entities\repositories\Auth\UserRepository;
use shop\helpers\UserHelper;
use yii\db\ActiveRecord;
use yii\di\Instance;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package shop\entities\Auth
 * @property $id integer
 * @property $status integer
 * @property $login string
 * @property $password string
 * @property $email string
 * @property $email_active_token string
 * @property $password_reset_token string
 * @property $created_at string
 * @property $updated_at string
 *
 * @property $auths Auth[]
 * @property Profile $profile
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     *
     */
    const STATUS_DELETE = 1;
    /**
     *
     */
    const STATUS_ACTIVE = 2;
    /**
     *
     */
    const STATUS_CONFIRM_EMAIL = 3;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
        ];
    }

    /**
     * @return UserQuery|\yii\db\ActiveQuery
     */
    public static function find(): UserQuery
    {
        return new UserQuery(static::class);
    }

    /**
     * @param string $password
     * @param string $login
     * @param string $email
     * @param int $status
     * @return User
     * @throws \yii\base\Exception
     */
    public static function requestSignup(
        string $password,
        string $login,
        string $email,
        $status = self::STATUS_CONFIRM_EMAIL
    ): self
    {
        $model = new static();
        $model->setLogin($login);
        $model->setEmail($email);
        $model->setStatus($status);
        $model->generateEmailActive();
        $model->setPassword($password);
        return $model;
    }


    /**
     * @param string $password
     * @param string $login
     * @param string $email
     * @return User
     * @throws \yii\base\InvalidConfigException
     */
    public static function createAdmin(
        string $password,
        string $login,
        string $email
    ): self
    {
        $model = new static();
        $model->setLogin($login);
        $model->setEmail($email);
        $model->setStatus(self::STATUS_ACTIVE);
        $model->setPassword($password);
        return $model;
    }

    /**
     * @param string $email
     * @throws \yii\base\InvalidConfigException
     */
    public function setEmail(string $email): void
    {
        /** @var UserRepository $repository */
        $repository = Instance::ensure(UserRepository::class);

        if ($repository->existsByEmail($email)) {
            throw new DomainException(sprintf('Email "%s" has already been token', $email));
        }
        $this->email = $email;
    }

    /**
     * @param string $login
     * @throws \yii\base\InvalidConfigException
     */
    public function setLogin(string $login)
    {
        /** @var UserRepository $repository */
        $repository = Instance::ensure(UserRepository::class);
        if ($repository->existsByLogin($login)) {
            throw new DomainException(sprintf('Login "%s" has already been token', $login));
        }
        $this->login = $login;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @throws \yii\base\Exception
     * @return void
     */
    public function generateEmailActive(): void
    {
        $this->email_active_token = UserHelper::generateEmailActive();
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generatePasswordReset(): void
    {
        $this->password_reset_token = UserHelper::generatePasswordReset();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordReset()
    {
        $this->password_reset_token = null;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = UserHelper::generatePasswordHash($password);
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
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status == static::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isConfirmEmail(): bool
    {
        return $this->status == static::STATUS_CONFIRM_EMAIL;
    }

    /**
     * @return bool
     */
    public function isDelete()
    {
        return $this->status == static::STATUS_DELETE;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::class, ['user_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    /**
     * @param int|string $id
     * @return UserQuery|IdentityInterface
     */
    public static function findIdentity($id)
    {
        return User::find()->id($id)->limit(1)->one();
    }

    /**
     * @param string $thumb
     * @param int $width
     * @return string
     */
    public function getAvatar(string $thumb, int $width): ?string
    {
        if (is_null($this->profile->src)) {
            $id = md5(strtolower(trim($this->email)));
            $default = '?d=' . urlencode('identicon');
            $width = $width ? '&amp;s=' . $width : '';
            return 'http://www.gravatar.com/avatar/' . $id . $default . $width;
        } else {
            return $this->profile->getThumbUrl($thumb);
        }

    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param string $source
     * @param string $sourceId
     * @return Auth
     * @throws \yii\base\InvalidConfigException
     */
    public function attachAuth(string $source, string $sourceId): Auth
    {
        $auth = Auth::create(
            $this->id,
            $source,
            $sourceId
        );
        return $auth;
    }


    /**
     * @return Profile
     * @throws \yii\base\InvalidConfigException
     */
    public function attachProfileBlank(): Profile
    {
        return Profile::blank($this->id);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }


    /**
     * @return string|void
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * @param string $authKey
     * @return bool|void
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}