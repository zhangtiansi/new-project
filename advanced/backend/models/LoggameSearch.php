<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Loggame;
use yii\db\Query;

/**
 * LogCoinRecordsSearch represents the model behind the search form about `app\models\LogCoinRecords`.
 */
class LoggameSearch extends Loggame
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'change_before', 'change_coin', 'change_after', 'prop_id'], 'integer'],
            [['game_no', 'ctime','bg_tm','end_tm'], 'safe'],
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
    public function searchTbs($params)
    {
        $query = new Query();
        $provider = new ActiveDataProvider([
                'query' => $query->from('log_coin_records'),
                'pagination' => ['pageSize' => 20,],
            ]);
        return $provider->getModels();
    }
    
    public function search($params)
    {
//         $lc = new LogCoinRecords();
        
        $query = Loggame::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly_gamelog,
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
            'change_before' => $this->change_before,
            'change_after' => $this->change_after,
            'prop_id' => $this->prop_id,
            'ctime' => $this->ctime,
            'game_no' => $this->game_no
        ]); 
        if ($this->change_coin!="" && $this->change_coin!=0){
//             if ($this->change_coin ==1 ){
//                 $query->andFilterWhere(['<','change_coin',0]);
//             }elseif ($this->change_coin ==2){
//                 $query->andFilterWhere(['>','change_coin',0]);
//             }
            $query->andFilterWhere(['>','change_coin',$this->change_coin]);
        }
        if ($this->bg_tm !=""){
            $query->andFilterWhere(['>','ctime',$this->bg_tm]);
        }
        if ($this->end_tm !=""){
            $query->andFilterWhere(['<','ctime',$this->end_tm]);
        }
//         Yii::error("dataprovider : ".print_r(var_dump($dataProvider),true));
        return $dataProvider;
    }
}
