<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class User
 * @package app\models
 *
 * @property $id integer
 * @property $username string
 * @property $auth_key string
 * @property $access_token string
 * @property $balance double
 */
class UserSearch extends User
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username'], 'string', 'max' => 100],
            [['balance'], 'double'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (! $this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'balance' => $this->balance,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
