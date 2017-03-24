<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GmActivity;

/**
 * GmActivitySearch represents the model behind the search form about `app\models\GmActivity`.
 */
class GmActivitySearch extends GmActivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'activity_type', 'total_fee', 'reward_coin', 'card_g', 'card_s', 'card_c'], 'integer'],
            [['activity_name', 'activity_desc', 'activity_begin', 'activity_end', 'utime'], 'safe'],
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
        $query = GmActivity::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'activity_begin' => $this->activity_begin,
            'activity_end' => $this->activity_end,
            'status' => $this->status,
            'activity_type' => $this->activity_type,
            'total_fee' => $this->total_fee,
            'reward_coin' => $this->reward_coin,
            'card_g' => $this->card_g,
            'card_s' => $this->card_s,
            'card_c' => $this->card_c,
            'utime' => $this->utime,
        ]);

        $query->andFilterWhere(['like', 'activity_name', $this->activity_name])
            ->andFilterWhere(['like', 'activity_desc', $this->activity_desc]);

        return $dataProvider;
    }
}
