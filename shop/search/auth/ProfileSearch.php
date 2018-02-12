<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 12.02.18
 * Time: 22:53
 */

namespace shop\search\auth;


use shop\entities\Auth\Profile;
use shop\entities\Auth\User;
use yii\data\ActiveDataProvider;

/**
 * Class ProfileSearch
 * @package shop\search\auth
 */
class ProfileSearch extends Profile
{
    public $login;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['created_at', 'updated_at', 'login', 'first_name'], 'string']
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Profile::find()->joinWith('user');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'first_name',
                    'login',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            Profile::tableName() . '.[[id]]' => $this->id
        ]);

        $query->andFilterWhere(['LIKE', Profile::tableName() . '.[[created_at]]', $this->created_at]);
        $query->andFilterWhere(['LIKE', Profile::tableName() . '.[[updated_at]]', $this->updated_at]);
        $query->andFilterWhere(['LIKE', Profile::tableName() . '.[[first_name]]', $this->first_name]);
        $query->andFilterWhere(['LIKE', User::tableName() . '.[[login]]', $this->login]);

        return $dataProvider;
    }
}