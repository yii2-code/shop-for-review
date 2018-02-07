<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 05.02.18
 * Time: 18:55
 */

declare(strict_types=1);

namespace shop\entities\Auth;


use app\behaviors\TimestampBehavior;
use app\modules\image\behaviors\UploadImageBehavior;
use DomainException;
use shop\entities\query\Auth\ProfileQuery;
use shop\entities\repositories\Auth\UserRepository;
use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @method getThumbUrl(string $thumb);
 *
 * Class Profile
 * @package shop\entities\Auth
 * @property $id int
 * @property $user_id int
 * @property $first_name string
 * @property $middle_name string
 * @property $last_name string
 * @property $about string
 * @property $src string
 * @property $created_at string
 * @property $updated_at string
 *
 * @property User $user
 */
class Profile extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'UploadImageBehavior' => [
                'class' => UploadImageBehavior::class,
                'attribute' => 'src',
                'path' => Yii::getAlias('@static/profile'),
                'thumbPath' => Yii::getAlias('@static/profile/thumb'),
                'url' => getenv('STATIC_HOST_INFO') . '/profile',
                'thumbUrl' => getenv('STATIC_HOST_INFO') . '/profile/thumb',
                'thumbs' => [
                    '160x160' => [
                        'weight' => 160,
                        'height' => 160,
                        'quality' => 100,
                    ]
                ]
            ],
        ];
    }


    /**
     * @return ProfileQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ProfileQuery(static::class);
    }

    /**
     * @param int $userId
     * @param string|null $firstName
     * @param string|null $middleName
     * @param string|null $lastName
     * @param string|null $about
     * @return Profile
     */
    public static function create(
        int $userId,
        string $firstName = null,
        string $middleName = null,
        string $lastName = null,
        string $about = null
    ): self
    {
        $model = new static();
        $model->setUserId($userId);
        $model->edit($firstName, $middleName, $lastName, $about);
        return $model;
    }

    /**
     * @param int $userId
     * @return Profile
     */
    public static function blank(int $userId): self
    {
        return static::create($userId);
    }

    /**
     * @param string|null $firstName
     * @param string|null $middleName
     * @param string|null $lastName
     * @param string|null $about
     */
    public function edit(
        string $firstName = null,
        string $middleName = null,
        string $lastName = null,
        string $about = null
    ): void
    {
        $this->first_name = $firstName;
        $this->middle_name = $middleName;
        $this->last_name = $lastName;
        $this->about = $about;
    }

    /**
     * @param int $id
     */
    public function setUserId(int $id): void
    {
        $repository = new UserRepository();

        if (!$repository->existsById($id)) {
            throw new DomainException('Unable to set field because the user not found');
        }

        $this->user_id = $id;
    }

    /**
     * @param UploadedFile|null $file
     */
    public function setSrc(UploadedFile $file = null): void
    {
        $this->src = $file;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}