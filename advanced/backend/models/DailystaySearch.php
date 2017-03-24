<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dailystay;
use yii\data\Pagination;
use app\models\GmChannelInfo;

/**
 * DailystaySearch represents the model behind the search form about `app\models\Dailystay`.
 */
class DailystaySearch extends Dailystay
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel', 'r_num', 's_num2', 's_num3', 's_num7'], 'integer'],
            [['udate'], 'safe'],
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
        $query = Dailystay::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['udate'=>SORT_DESC,'channel'=>SORT_ASC]]
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
            'r_num' => $this->r_num,
            's_num2' => $this->s_num2,
            's_num3' => $this->s_num3,
            's_num7' => $this->s_num7,
        ]);
        if ($this->channel!=""&& $this->channel!=0)
        {
            $dplist=GmChannelInfo::getChannelDropList();
            Yii::error("channel dropdown list :".print_r($dplist,true));
            $channelName=$dplist[$this->channel];
            $query->andFilterWhere(['channel'=>GmChannelInfo::findChannelidByName($channelName)]);
        }

        return $dataProvider;
    }
    
    public function searchChannel($params)
    {
        $query = Dailystay::find();
    
        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['udate'=>SORT_DESC,'channel'=>SORT_ASC]]
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
            'r_num' => $this->r_num,
            's_num2' => $this->s_num2,
            's_num3' => $this->s_num3,
            's_num7' => $this->s_num7,
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
    
        return $dataProvider;
    }

    public function new_search($request){
        $query = Dailystay::find();
        if(isset($request['cid']) && $request['cid'] !=''){
            $query->filterWhere(['channel'=>$request['cid']]);
        }
        if(isset($request['pay_time']) && $request['pay_time'] !=''){
            $query->andFilterWhere(['udate' => $request['pay_time']]);
        }
        $query->orderBy(['id' => SORT_DESC]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);

        $result = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        foreach($result as $key=>$value){
            if(is_numeric(trim($value->channel))){
                $channel_result = GmChannelInfo::find()->where(['cid'=>trim($value->channel)])->one();
                $result[$key]['channel'] = $channel_result->channel_name;
            }
        }
        return $list=array(0=>$result,1=>$pagination,2=>$count);
    }
}
