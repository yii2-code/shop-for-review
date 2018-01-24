<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 23.01.18
 * Time: 22:42
 */

declare(strict_types=1);

namespace shop\entities\Product;

use app\behaviors\TimestampBehavior;
use paulzi\nestedsets\NestedSetsBehavior;
use shop\entities\query\Product\CategoryQuery;
use shop\helpers\CategoryHelper;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @method appendTo(ActiveRecord $node)
 * @method CategoryQuery getDescendants($depth = null, $andSelf = false, $backOrder = false)
 * @method CategoryQuery getParent()
 * @method bool isRoot()
 * @method bool isChildOf(ActiveRecord $node)
 *
 * Class Category
 * @package shop\entities\Product
 * @property $id int
 * @property $status int
 * @property $depth int
 * @property $title string
 * @property $description string
 * @property $created_at string
 * @property $updated_at string
 */
class Category extends ActiveRecord
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
        return '{{%category}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'NestedSetsBehavior' => NestedSetsBehavior::class,
        ];
    }

    /**
     * @return CategoryQuery|\yii\db\ActiveQuery
     */
    public static function find(): CategoryQuery
    {
        return new CategoryQuery(static::class);
    }

    /**
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @param string $title
     * @param string $description
     * @param int $status
     * @return Category
     */
    public static function create(
        string $title,
        string $description,
        int $status
    ): self
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
    public function edit(
        string $title,
        string $description,
        int $status
    ): void
    {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return ArrayHelper::getValue(CategoryHelper::getDropDown(), $this->status);
    }
}