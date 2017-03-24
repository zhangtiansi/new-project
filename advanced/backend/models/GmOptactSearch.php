<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GmOptact;

/**
 * GmOptactSearch represents the model behind the search form about `app\models\GmOptact`.
 */
class GmOptactSearch extends GmOptact
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'act_type'], 'integer'],
            [['name', 'act_title', 'act_desc', 'begin_tm', 'end_tm'], 'safe'],
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
        $query = GmOptact::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'act_type' => $this->act_type,
            'begin_tm' => $this->begin_tm,
            'end_tm' => $this->end_tm,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'act_title', $this->act_title])
            ->andFilterWhere(['like', 'act_desc', $this->act_desc]);

        return $dataProvider;
    }
}
