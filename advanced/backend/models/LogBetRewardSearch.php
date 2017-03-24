<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogBetReward;

/**
 * LogBetRewardSearch represents the model behind the search form about `app\models\LogBetReward`.
 */
class LogBetRewardSearch extends LogBetReward
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bid', 'bettype', 'gid', 'reward', 'status'], 'integer'],
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
        $query = LogBetReward::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['id'=>SORT_DESC]]
                    ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'bid' => $this->bid,
            'gid' => $this->gid,
            'reward' => $this->reward,
            'ctime' => $this->ctime,
            'status' => $this->status,
        ]);
        if ($this->bettype!="" && $this->bettype!=0){
            $query->andFilterWhere([
                'bettype' => $this->bettype,
            ]);
        }
        

        return $dataProvider;
    }
}
