<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgWarconfig;

/**
 * CfgWarconfigSearch represents the model behind the search form about `app\models\CfgWarconfig`.
 */
class CfgWarconfigSearch extends CfgWarconfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'di_coin', 'shang_coin', 'xia_coin', 'seat_coin', 'xia_turn', 'ya_shui', 'war_id', 'stime', 'robot_coin', 'war_open', 'max_coin', 'seat_coin_min', 'prize_shui', 'prize_coin', 'prize_coin_max', 'card_1', 'card_2', 'card_3', 'card_type_1', 'card_type_2', 'card_type_3'], 'integer'],
            [['prize_name_max'], 'safe'],
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
        $query = CfgWarconfig::find();

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
            'di_coin' => $this->di_coin,
            'shang_coin' => $this->shang_coin,
            'xia_coin' => $this->xia_coin,
            'seat_coin' => $this->seat_coin,
            'xia_turn' => $this->xia_turn,
            'ya_shui' => $this->ya_shui,
            'war_id' => $this->war_id,
            'stime' => $this->stime,
            'robot_coin' => $this->robot_coin,
            'war_open' => $this->war_open,
            'max_coin' => $this->max_coin,
            'seat_coin_min' => $this->seat_coin_min,
            'prize_shui' => $this->prize_shui,
            'prize_coin' => $this->prize_coin,
            'prize_coin_max' => $this->prize_coin_max,
            'card_1' => $this->card_1,
            'card_2' => $this->card_2,
            'card_3' => $this->card_3,
            'card_type_1' => $this->card_type_1,
            'card_type_2' => $this->card_type_2,
            'card_type_3' => $this->card_type_3,
        ]);

        $query->andFilterWhere(['like', 'prize_name_max', $this->prize_name_max]);

        return $dataProvider;
    }
}
