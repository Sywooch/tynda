<?php

namespace common\models\jobs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\jobs\JobVacancy;

/**
 * BackJobVacancySearch represents the model behind the search form about `common\models\jobs\JobVacancy`.
 */
class BackJobVacancySearch extends JobVacancy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'status', 'employment', 'education'], 'integer'],
            [['top_date', 'vip_date', 'title', 'description', 'address', 'duties', 'require', 'conditions', 'created_at', 'updated_at', 'm_keyword', 'm_description'], 'safe'],
            [['salary'], 'number'],
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
        $query = JobVacancy::find();

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
            'status' => $this->status,
            'top_date' => $this->top_date,
            'vip_date' => $this->vip_date,
            'employment' => $this->employment,
            'salary' => $this->salary,
            'education' => $this->education,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'duties', $this->duties])
            ->andFilterWhere(['like', 'require', $this->require])
            ->andFilterWhere(['like', 'conditions', $this->conditions])
            ->andFilterWhere(['like', 'm_keyword', $this->m_keyword])
            ->andFilterWhere(['like', 'm_description', $this->m_description]);

        return $dataProvider;
    }
}