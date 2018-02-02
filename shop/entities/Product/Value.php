<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 02.02.18
 * Time: 13:40
 */

declare(strict_types=1);

namespace shop\entities\Product;


use app\behaviors\TimestampBehavior;
use DomainException;
use shop\entities\query\Product\ValueQuery;
use shop\entities\repositories\Product\CharacteristicRepository;
use shop\entities\repositories\Product\ProductRepository;
use yii\db\ActiveRecord;


/**
 * Class Value
 * @package shop\entities\Product
 * @property $id int
 * @property $product_id int
 * @property $characteristic_id int
 * @property $value string
 * @property $created_at string
 * @property $updated_at string
 */
class Value extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%value}}';
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
     * @return ValueQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ValueQuery(static::class);
    }

    /**
     * @param int $productId
     * @param int $characteristicId
     * @param string|null $value
     * @return Value
     */
    public static function create(int $productId, int $characteristicId, string $value = null): self
    {
        $productRepository = new ProductRepository();

        if (!$productRepository->existsById($productId)) {
            throw new DomainException('Unable to save model because the product not found');
        }


        $characteristicRepository = new CharacteristicRepository();

        if (!$characteristicRepository->existsById($characteristicId)) {
            throw new DomainException('Unable to save model because the characteristic not found');
        }

        $model = new static();
        $model->product_id = $productId;
        $model->characteristic_id = $characteristicId;
        $model->value = $value;
        return $model;
    }

    /**
     * @param string|null $value
     */
    public function edit(string $value = null): void
    {
        $this->value = $value;
    }
}