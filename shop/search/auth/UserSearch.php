<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 11.02.18
 * Time: 22:01
 */

namespace shop\search\auth;


use shop\entities\Auth\User;
use yii\data\ActiveDataProvider;

/**
 * Class User
 * @package shop\search
 */
class UserSearch extends User
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['created_at', 'updated_at', 'login', 'email'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status
        ]);

        $query->andFilterWhere(['LIKE', 'created_at', $this->created_at]);
        $query->andFilterWhere(['LIKE', 'updated_at', $this->updated_at]);
        $query->andFilterWhere(['LIKE', 'login', $this->login]);
        $query->andFilterWhere(['LIKE', 'email', $this->email]);

        return $dataProvider;
    }
}