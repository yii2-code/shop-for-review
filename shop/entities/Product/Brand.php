<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 22:46
 */

declare(strict_types=1);

namespace shop\entities\Product;

use app\behaviors\TimestampBehavior;
use shop\entities\query\Product\BrandQuery;
use yii\db\ActiveRecord;

/**
 * Class Brand
 * @package shop\entities\Product
 * @property $id int
 * @property $status int
 * @property $title string
 * @property $description string
 * @property $created_at string
 * @property $updated_at string
 */
class Brand extends ActiveRecord
{
    /**
     *
     */
    const STATUS_ACTIVE = 1;

    /**
     *
     */
    const STATUS_DELETE = 2;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%brand}}';
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
     * @return BrandQuery
     */
    public static function find(): BrandQuery
    {
        return new BrandQuery(static::class);
    }

    /**
     * @param string $title
     * @param string $description
     * @param int $status
     * @return Brand
     */
    public static function create(string $title, string $description, int $status): self
    {
        $model = new static();
        $model->title = $title;
        $model->description = $description;
        $model->status = $status;
        return $model;
    }

    /**
     * @param string $title
     * @param string $description
     * @param int $status
     */
    public function edit(string $title, string $description, int $status): void
    {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
    }
}