<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AgentInfo;

/**
 * AgentInfoSearch represents the model behind the search form about `app\models\AgentInfo`.
 */
class AgentInfoSearch extends AgentInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'account_id', 'money', 'status'], 'integer'],
            [['agent_name', 'agent_desc'], 'safe'],
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
        $query = AgentInfo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'account_id' => $this->account_id,
            'money' => $this->money,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'agent_name', $this->agent_name])
            ->andFilterWhere(['like', 'agent_desc', $this->agent_desc]);

        return $dataProvider;
    }
}
