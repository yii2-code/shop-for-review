<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 18:39
 */

declare(strict_types=1);

namespace shop\entities\Product;

use app\behaviors\TimestampBehavior;
use DomainException;
use shop\entities\query\Product\ProductQuery;
use shop\entities\repositories\Product\BrandRepository;
use shop\entities\repositories\Product\CategoryRepository;
use yii\db\ActiveRecord;

/**
 * Class Product
 * @package shop\entities\Product
 * @property $id int
 * @property $status int
 * @property $price int
 * @property $old_price int
 * @property $brand_id int
 * @property $category_main_id int
 * @property $title string
 * @property $announce string
 * @property $description string
 * @property $created_at string
 * @property $updated_at string
 *
 * @property $brand Brand
 * @property $categoryMain Category
 */
class Product extends ActiveRecord
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
        return '{{%product}}';
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
     * @return ProductQuery
     */
    public static function find(): ProductQuery
    {
        return new ProductQuery(static::class);
    }

    /**
     * @param string $title
     * @param string $announce
     * @param string $description
     * @param int $status
     * @param int $price
     * @param int $brandId
     * @param int $categoryMainId
     * @param int|null $oldPrice
     * @return Product
     */
    public static function create(
        string $title,
        string $announce,
        string $description,
        int $status,
        int $price,
        int $brandId,
        int $categoryMainId,
        int $oldPrice = null
    ): self
    {
        $model = new static();
        $model->title = $title;
        $model->announce = $announce;
        $model->description = $description;
        $model->status = $status;
        $model->editPrice($price, $oldPrice);
        $model->setBrandId($brandId);
        $model->setCategoryMainId($categoryMainId);
        return $model;
    }

    /**
     * @param string $title
     * @param string $announce
     * @param string $description
     * @param int $status
     * @param int $brandId
     * @param int $categoryMainId
     */
    public function edit(
        string $title,
        string $announce,
        string $description,
        int $status,
        int $brandId,
        int $categoryMainId
    ): void
    {
        $this->title = $title;
        $this->announce = $announce;
        $this->description = $description;
        $this->status = $status;
        $this->setBrandId($brandId);
        $this->setCategoryMainId($categoryMainId);
    }

    /**
     * @param int $price
     * @param int|null $oldPrice
     */
    public function editPrice(int $price, int $oldPrice = null)
    {
        $this->price = $price;
        $this->old_price = $oldPrice;
    }

    /**
     * @param int $id
     */
    public function setBrandId(int $id): void
    {
        $repository = new BrandRepository();
        if (!$repository->existsById($id)) {
            throw new DomainException('Incorrectly brand');
        }
        $this->brand_id = $id;
    }

    /**
     * @param int $id
     */
    public function setCategoryMainId(int $id): void
    {
        $repository = new CategoryRepository();
        if (!$repository->existsById($id)) {
            throw new DomainException('Incorrectly category');
        }
        $this->category_main_id = $id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryMain()
    {
        return $this->hasOne(Category::class, ['id' => 'category_main_id']);
    }
}