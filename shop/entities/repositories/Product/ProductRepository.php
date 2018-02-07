<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 18:47
 */

declare(strict_types=1);

namespace shop\entities\repositories\Product;


use app\modules\image\models\Image;
use shop\entities\Product\Product;

/**
 * Class ProductRepository
 * @package shop\entities\repositories\Product
 */
class ProductRepository
{
    /**
     * @param int $id
     * @return null|Product
     */
    public function findOne(int $id): ?Product
    {
        return Product::find()->id($id)->limit(1)->one();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        return Product::find()->id($id)->exists();
    }

    /**
     * @return array|Product[]|\yii\db\ActiveRecord[]
     */
    public function findAll()
    {
        return Product::find()->all();
    }


    /**
     * @return array|Product[]
     */
    public function carousel(): array
    {
        return Product::find()
            ->innerJoin(Image::tableName(),
                ['record_id' => Product::tableName() . '.[[id]]', 'class' => Product::class, 'main' => Image::MAIN]
            )
            ->active()->orderBy(['id' => SORT_DESC])->limit(10)->all();
    }
}