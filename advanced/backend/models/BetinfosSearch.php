<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 *
 */
class BetinfosSearch extends Betinfos
{
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[  'gid', 'bid', 'bet_1', 'bet_2', 'bet_3', 'bet_4', 'bet_5', 'bet_6', 'bettype','bettime', 'reward','rewardtime'], 'safe']
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
        $query = Betinfos::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'sort'=> ['defaultOrder' =>
                ['bettime'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gid' => $this->gid
        ]);
        if ($this->bettype!="" && $this->bettype!=0){
            $query->andFilterWhere([
                'bettype' => $this->bettype,
            ]);
        }
//         $query->andFilterWhere(['like', 'ctime', $this->ctime]);

        return $dataProvider;
    }
    
   
}
