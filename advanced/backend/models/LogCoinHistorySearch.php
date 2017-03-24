<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogCoinHistory;

/**
 * LogCoinHistorySearch represents the model behind the search form about `app\models\LogCoinHistory`.
 */
class LogCoinHistorySearch extends LogCoinHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'coin_box', 'change_type', 'change_before', 'change_coin', 'change_after', 'prop_id'], 'integer'],
            [['game_no', 'ctime'], 'safe'],
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
        $query = LogCoinHistory::find();

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'coin_box' => $this->coin_box,
            'change_type' => $this->change_type,
            'change_before' => $this->change_before,
            'change_coin' => $this->change_coin,
            'change_after' => $this->change_after,
            'prop_id' => $this->prop_id,
            'ctime' => $this->ctime,
        ]);
        if ($this->change_type!="" && $this->change_type!=0){
            $query->andFilterWhere(['change_type' => $this->change_type]);
        }
        if ($this->change_coin!="" && $this->change_coin!=0){
            //             if ($this->change_coin ==1 ){
            //                 $query->andFilterWhere(['<','change_coin',0]);
            //             }elseif ($this->change_coin ==2){
            //                 $query->andFilterWhere(['>','change_coin',0]);
            //             }
            $query->andFilterWhere(['>','change_coin',$this->change_coin]);
        }

        return $dataProvider;
    }
}
