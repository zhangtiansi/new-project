<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;

/**
 * This is the model class for table "gameweightlist".
 *
 * @property integer $win_uid
 * @property string $win_coin
 * @property integer $ct
 * @property string $totalweight
 * @property string $avg_weight
 * @property integer $power
 * @property integer $money
 * @property integer $status
 * @property string $reg_channel
 * @property string $last_login
 * @property string $gamePlay
 * @property integer $game_win
 */
class GameweightlistSearch extends Gameweightlist
{
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [ 
             [['win_uid', 'ct', 'power', 'money', 'status', 'gamePlay', 'game_win','win_coin', 'totalweight', 'avg_weight','last_login','reg_channel'], 'safe'],  
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
        $query = Gameweightlist::find();
    
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
            'win_uid' => $this->win_uid, 
        ]);
    
//         $query->andFilterWhere(['like', 'account_name', $this->account_name])
//         ->andFilterWhere(['like', 'account_pwd', $this->account_pwd])
//         ->andFilterWhere(['like', 'pwd_a', $this->pwd_a])
//         ->andFilterWhere(['like', 'sim_serial', $this->sim_serial])
//         ->andFilterWhere(['like', 'device_id', $this->device_id])
//         ->andFilterWhere(['like', 'op_uuid', $this->op_uuid])
//         ->andFilterWhere(['like', 'reg_channel', $this->reg_channel])
//         ->andFilterWhere(['like', 'token', $this->token]);
    
        return $dataProvider;
    }
}
