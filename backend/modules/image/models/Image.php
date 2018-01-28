<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 19:05
 */

declare(strict_types=1);

namespace backend\modules\image\models;


use app\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Image
 * @package backend\modules\image\models
 * @property $id int
 * @property $record_id int
 * @property $position int
 * @property $main int
 * @property $name string
 * @property $src string
 * @property $class string
 * @property $token string
 * @property $created_at string
 * @property $updated_at string
 */
class Image extends ActiveRecord
{
    const MAIN = 1;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%image}}';
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
     * @return ImageQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ImageQuery(static::class);
    }


    /**
     * @param string $name
     * @param string $src
     * @param string $class
     * @param int $position
     * @param int|null $main
     * @return Image
     */
    public static function create(string $name, string $src, string $class, int $position, int $main = null): self
    {
        $model = new static();
        $model->src = $src;
        $model->name = $name;
        $model->class = $class;
        $model->main = $main;
        $model->position = $position;
        return $model;
    }

    /**
     * @param string $name
     */
    public function edit(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $recordId
     */
    public function setRecordId(int $recordId): void
    {
        $this->record_id = $recordId;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     *
     */
    public function removeToken()
    {
        $this->token = null;
    }
}