<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogBetResults;

/**
 * LogBetResultsSearch represents the model behind the search form about `app\models\LogBetResults`.
 */
class LogBetResultsSearch extends LogBetResults
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bid', 'result', 'coin', 'player_num'], 'integer'],
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
        $query = LogBetResults::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['bid'=>SORT_DESC]]
                    ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'bid' => $this->bid,
            'ctime' => $this->ctime,
            'coin' => $this->coin,
            'player_num' => $this->player_num,
        ]);
        if ($this->result!="" && $this->result!=0){
            $query->andFilterWhere([
                'result' => $this->result,
            ]);
        }

        return $dataProvider;
    }
}
