<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogWarRecord;

/**
 * LogWarRecordSearch represents the model behind the search form about `app\models\LogWarRecord`.
 */
class LogWarRecordSearch extends LogWarRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['war_id', 'men1_coin', 'men1_prize', 'men2_coin', 'men2_prize', 'men3_coin', 'men3_prize', 'men4_coin', 'men4_prize', 'banker_id', 'banker_coin'], 'integer'],
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
        $query = LogWarRecord::find();

        $dataProvider = new ActiveDataProvider([
             'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['war_id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'war_id' => $this->war_id,
            'men1_coin' => $this->men1_coin,
            'men1_prize' => $this->men1_prize,
            'men2_coin' => $this->men2_coin,
            'men2_prize' => $this->men2_prize,
            'men3_coin' => $this->men3_coin,
            'men3_prize' => $this->men3_prize,
            'men4_coin' => $this->men4_coin,
            'men4_prize' => $this->men4_prize,
            'banker_id' => $this->banker_id,
            'banker_coin' => $this->banker_coin,
            'ctime' => $this->ctime,
        ]);

        return $dataProvider;
    }
}
