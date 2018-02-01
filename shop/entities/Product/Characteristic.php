<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 16:02
 */

declare(strict_types=1);

namespace shop\entities\Product;


use app\behaviors\JsonBehavior;
use app\behaviors\TimestampBehavior;
use shop\entities\query\Product\CharacteristicQuery;
use shop\entities\repositories\Product\CharacteristicRepository;
use yii\db\ActiveRecord;

/**
 * Class Characteristic
 * @package shop\entities\Product
 * @property $id int
 * @property $type int
 * @property $position int
 * @property $required int
 * @property $title string
 * @property $default string
 * @property $variants array
 * @property $created_at string
 * @property $updated_at string
 */
class Characteristic extends ActiveRecord
{
    /**
     *
     */
    const REQUIRED_NO = 0;
    /**
     *
     */
    const REQUIRED_YES = 1;

    /**
     *
     */
    const TYPE_STRING = 1;
    /**
     *
     */
    const TYPE_INTEGER = 2;
    /**
     *
     */
    const TYPE_FLOAT = 3;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%characteristic}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'JsonBehavior' => [
                'class' => JsonBehavior::class,
                'attribute' => 'variants',
            ]
        ];
    }

    /**
     * @return CharacteristicQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new CharacteristicQuery(static::class);
    }

    /**
     * @param string $title
     * @param int $type
     * @param int $required
     * @param null $default
     * @param array $variants
     * @return Characteristic
     */
    public static function create(
        string $title,
        int $type,
        int $required,
        $default = null,
        array $variants = []
    ): self
    {
        $model = new static();
        $model->edit($title, $type, $required, $default, $variants);
        $model->setPosition();
        return $model;
    }

    /**
     * @param string $title
     * @param int $type
     * @param int $required
     * @param null $default
     * @param array $variants
     */
    public function edit(
        string $title,
        int $type,
        int $required,
        $default = null,
        array $variants = []
    ): void
    {
        $this->title = $title;
        $this->type = $type;
        $this->required = $required;
        $this->default = $default;
        $this->variants = $variants;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(int $position = null): void
    {
        $repository = new CharacteristicRepository();

        if (is_null($position)) {
            $position = $repository->maxPosition();
        }
        $this->position = $position;
    }
}