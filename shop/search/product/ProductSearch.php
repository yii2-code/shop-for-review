<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 13:41
 */

namespace shop\search\product;


use shop\entities\Product\Product;
use yii\data\ActiveDataProvider;

/**
 * Class ProductSearch
 * @package shop\search
 */
class ProductSearch extends Product
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'price', 'brand_id', 'category_main_id', 'status'], 'integer'],
            [['title', 'created_at', 'updated_at'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            Product::tableName() . '.[[id]]' => $this->id,
            Product::tableName() . '.[[status]]' => $this->status,
            Product::tableName() . '.[[price]]' => $this->price,
            Product::tableName() . '.[[brand_id]]' => $this->brand_id,
            Product::tableName() . '.[[category_main_id]]' => $this->category_main_id,
        ]);

        $query->andFilterWhere(['LIKE', Product::tableName() . '.[[title]]', $this->title]);
        $query->andFilterWhere(['LIKE', Product::tableName() . '.[[created_at]]', $this->created_at]);
        $query->andFilterWhere(['LIKE', Product::tableName() . '.[[updated_at]]', $this->updated_at]);

        return $dataProvider;
    }
}