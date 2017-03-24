<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataDailyStay;

/**
 * DataDailyStaySearch represents the model behind the search form about `app\models\DataDailyStay`.
 */
class DataDailyStaySearch extends DataDailyStay
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['udate','channel'], 'safe'],
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
        $query = DataDailyStay::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['udate'=>SORT_DESC,'channel'=>SORT_DESC ]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

         $query->andFilterWhere([
            'id' => $this->id,
            'udate' => $this->udate,
        ]);
          
         
        $query->andFilterWhere(['like', 'channel', $this->channel]);
        
        return $dataProvider;
    }
    public function searchChannel($params)
    {
        $query = DataDailyStay::find();
    
        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['udate'=>SORT_DESC,'channel'=>SORT_DESC ]]
        ]);
    
        $this->load($params);
    
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
    
        $query->andFilterWhere([
            'id' => $this->id,
            'udate' => $this->udate,
        ]);
        $c = GmChannelInfo::findOne(['opname'=> Yii::$app->user->id]);
        if(is_object($c)){
            $channel = $c->cid;
            $query->andFilterWhere(['channel'=> $channel]);
                        Yii::error("channelsel ".$channel." userid : ".Yii::$app->user->id." channel id  ".$c->cid);
        }else{
            Yii::error("channelsel notfound xxx,opname:".Yii::$app->user->id);
            $query->andFilterWhere(['channel'=> "xxx"]);
        }
         
//         $query->andFilterWhere(['like', 'channel', $this->channel]);
    
        return $dataProvider;
    }
    
}
