<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GmOrderlist;

/**
 * GmOrderlistSearch represents the model behind the search form about `app\models\GmOrderlist`.
 */
class GmOrderlistSearch extends GmOrderlist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'playerid', 'status', 'vipcard_g', 'vipcard_s', 'vipcard_c'], 'integer'],
            [['orderid', 'productid', 'reward', 'starttm','endtm','source', 'fee', 'transaction_id', 'transaction_time', 'ctime', 'utime', 'price'], 'safe'],
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
        $query = GmOrderlist::find();

        $dataProvider = new ActiveDataProvider([
//             'db'=>Yii::$app->db_readonly,
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
        if ($this->status==""){
            $this->status=2;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'playerid' => $this->playerid,
            'transaction_time' => $this->transaction_time,
            'status' => $this->status,
            'vipcard_g' => $this->vipcard_g,
            'vipcard_s' => $this->vipcard_s,
            'vipcard_c' => $this->vipcard_c,
        ]);
        if ($this->starttm !="" )
        {
            $query->andFilterWhere(['>=', 'utime', $this->starttm." 00:00:00"]);
        }
        if ($this->endtm !="" )
        {
            $query->andFilterWhere(['<=', 'utime', $this->endtm." 23:59:59"]);
        }
        if ($this->productid !="" && $this->productid!=0)
        {
            $pid = CfgProducts::getProductByid($this->productid);
            $query->andFilterWhere(['productid'=>$pid]);
        }
        
        $query->andFilterWhere(['like', 'orderid', $this->orderid])
            ->andFilterWhere(['like', 'reward', $this->reward])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'fee', $this->fee])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id])
            ->andFilterWhere(['like', 'price', $this->price]);

        return $dataProvider;
    }
}
