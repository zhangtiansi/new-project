<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgGiftReward;

/**
 * CfgGiftRewardSearch represents the model behind the search form about `app\models\CfgGiftReward`.
 */
class CfgGiftRewardSearch extends CfgGiftReward
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'chance', 'threshold', 'coin_pool', 'reward', 'gift_id'], 'integer'],
            [['reward_name', 'ctime', 'gfit_name'], 'safe'],
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
        $query = CfgGiftReward::find();

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
            'chance' => $this->chance,
            'threshold' => $this->threshold,
            'coin_pool' => $this->coin_pool,
            'reward' => $this->reward,
            'ctime' => $this->ctime,
            'gift_id' => $this->gift_id,
        ]);

        $query->andFilterWhere(['like', 'reward_name', $this->reward_name])
            ->andFilterWhere(['like', 'gfit_name', $this->gfit_name]);

        return $dataProvider;
    }
}
