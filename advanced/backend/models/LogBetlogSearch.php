<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogBetlog;

/**
 * LogBetlogSearch represents the model behind the search form about `app\models\LogBetlog`.
 */
class LogBetlogSearch extends LogBetlog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'account_id', 'bet_1', 'bet_2', 'bet_3', 'bet_4', 'bet_5', 'bet_6', 'mark', 'bid'], 'integer'],
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
        $query = LogBetlog::find();

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
            'account_id' => $this->account_id,
            'bet_1' => $this->bet_1,
            'bet_2' => $this->bet_2,
            'bet_3' => $this->bet_3,
            'bet_4' => $this->bet_4,
            'bet_5' => $this->bet_5,
            'bet_6' => $this->bet_6,
            'mark' => $this->mark,
            'bid' => $this->bid,
        ]);

        return $dataProvider;
    }
}
