<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 23:05
 */

namespace shop\search\product;


use shop\entities\Product\Characteristic;
use yii\data\ActiveDataProvider;

class CharacteristicSearch extends Characteristic
{
    public function rules()
    {
        return [
            [['title', 'created_at', 'updated_at'], 'string'],
            [['type', 'id'], 'integer']
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Characteristic::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            Characteristic::tableName() . '.[[id]]' => $this->id,
        ]);

        $query->andFilterWhere(['LIKE', Characteristic::tableName() . '.[[title]]', $this->title]);
        $query->andFilterWhere(['LIKE', Characteristic::tableName() . '.[[created_at]]', $this->created_at]);
        $query->andFilterWhere(['LIKE', Characteristic::tableName() . '.[[updated_at]]', $this->updated_at]);

        return $dataProvider;
    }
}