<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User {
    public $roleName;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['username', 'email', 'password', 'roleName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'username',
                'email',
                'roleName' => [
                    'asc' => ['auth_assignment.item_name' => SORT_DESC],
                    'desc' => ['auth_assignment.item_name' => SORT_ASC],
                    'defaultSort' => 'asc',
                    'label' => 'Szerep'
                ]
            ]
        ]);

        $this->load($params);

        $query->joinWith('authAssignment');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password]);

        if (strtolower($this->roleName === 'student')) {
            $query->andFilterWhere(['is', 'auth_assignment.item_name', new Expression('null')]);
        } else {
            $query->andFilterWhere(['like', 'auth_assignment.item_name', $this->roleName]);
        }

        return $dataProvider;
    }
}
