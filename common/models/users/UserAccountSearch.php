<?php

namespace common\models\users;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\users\UserAccount;

/**
 * UserAccountSearch represents the model behind the search form about `common\models\users\UserAccount`.
 */
class UserAccountSearch extends UserAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'invoice'], 'integer'],
            [['pay_in', 'pay_out'], 'number'],
            [['date', 'description', 'service'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = UserAccount::find()->orderBy('date DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_user' => $this->id_user,
            'pay_in' => $this->pay_in,
            'pay_out' => $this->pay_out,
            'invoice' => $this->invoice,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'service', $this->service]);

        return $dataProvider;
    }
}
