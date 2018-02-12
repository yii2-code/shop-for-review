<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 12.02.18
 * Time: 19:13
 */

namespace shop\entities\read;


use shop\entities\Product\Category;
use shop\entities\Product\CategoryAssign;
use shop\entities\Product\Product;
use yii\data\ActiveDataProvider;

/**
 * Class ProductRead
 * @package shop\entities\read
 */
class ProductRead
{
    /**
     * @param Category $category
     * @return ActiveDataProvider
     */
    public function findAllByCategory(Category $category): ActiveDataProvider
    {
        $categoryIds = $category->getDescendants()->select('id')->column();
        $categoryIds = array_merge([$category->id], $categoryIds);
        $query = Product::find()
            ->joinWith('categories')
            ->groupBy([Product::tableName() . '.[[id]]'])
            ->andWhere([
                'OR',
                [Product::tableName() . '.[[category_main_id]]' => $categoryIds],
                [CategoryAssign::tableName() . '.[[category_id]]' => $categoryIds]
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 16,
                'pageSizeLimit' => [16, 80]
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id',
                    'title',
                    'price',
                ]
            ]
        ]);

        return $dataProvider;
    }
}