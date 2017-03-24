<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgDailyReward;

/**
 * CfgDailyRewardSearch represents the model behind the search form about `app\models\CfgDailyReward`.
 */
class CfgDailyRewardSearch extends CfgDailyReward
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'day_num', 'reward'], 'integer'],
            [['ctime'], 'safe'],
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
        $query = CfgDailyReward::find();

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
            'day_num' => $this->day_num,
            'reward' => $this->reward,
            'ctime' => $this->ctime,
        ]);

        return $dataProvider;
    }
}
