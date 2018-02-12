<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 14:29
 */

namespace shop\search\product;


use shop\entities\Product\Brand;
use yii\data\ActiveDataProvider;

/**
 * Class BrandSearch
 * @package shop\search
 */
class BrandSearch extends Brand
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['title', 'created_at', 'updated_at'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Brand::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            Brand::tableName() . '.[[id]]' => $this->id,
            Brand::tableName() . '.[[status]]' => $this->status,
        ]);

        $query->andFilterWhere(['LIKE', Brand::tableName() . '.[[title]]', $this->title]);
        $query->andFilterWhere(['LIKE', Brand::tableName() . '.[[created_at]]', $this->created_at]);
        $query->andFilterWhere(['LIKE', Brand::tableName() . '.[[updated_at]]', $this->updated_at]);

        return $dataProvider;
    }
}