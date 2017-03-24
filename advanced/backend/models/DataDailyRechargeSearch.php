<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataDailyRecharge;
use yii\data\Pagination;
/**
 * DataDailyRechargeSearch represents the model behind the search form about `app\models\DataDailyRecharge`.
 */
class DataDailyRechargeSearch extends DataDailyRecharge
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pnum', 'ptime'], 'integer'],
            [['udate', 'channel', 'source', 'totalfee', 'up', 'avg'], 'safe'],
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
        $query = DataDailyRecharge::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['udate'=>SORT_DESC,'channel'=>SORT_DESC,'source'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id, 
            'pnum' => $this->pnum,
            'ptime' => $this->ptime,
        ]);

        if ($this->channel!=""&& $this->channel!=0)
        {
            $dplist=GmChannelInfo::getChannelDropList();
            $channelName=$dplist[$this->channel];
            $query->andFilterWhere(['channel'=>GmChannelInfo::findChannelidByName($channelName)]);
        }
        $query->andFilterWhere(['like', 'source', $this->source])
        ->andFilterWhere(['like', 'udate', $this->udate])
        ->andFilterWhere(['like', 'totalfee', $this->totalfee])
        ->andFilterWhere(['like', 'up', $this->up])
        ->andFilterWhere(['like', 'avg', $this->avg]);
        return $dataProvider;
    }
    public function channelsearch($params)
    {
        $query = DataDailyRecharge::find();
    
        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['udate'=>SORT_DESC,'channel'=>SORT_DESC,'source'=>SORT_DESC]]
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
            'pnum' => $this->pnum,
            'ptime' => $this->ptime,
        ]);
        $c = GmChannelInfo::findOne(['opname'=> Yii::$app->user->id]);
        if(is_object($c)){
            $channel = $c->cid;
            $query->andFilterWhere(['channel'=> $channel]);
//             Yii::error("channelsel ".$channel." userid : ".Yii::$app->user->id." channel id  ".$c->cid);
        }else{
            Yii::error("channelsel notfound xxx,opname:".Yii::$app->user->id);
            $query->andFilterWhere(['channel'=> "xxx"]);
        }
    
        $query->andFilterWhere(['like', 'source', $this->source]);
    
        return $dataProvider;
    }

    public function new_search($request){
        $query = DataDailyRecharge::find();
        if(isset($request['cid']) && $request['cid'] !=''){
            $gm_channel_result = GmChannelInfo::findOne(['cid'=> $data['cid']]);
            $query->filterWhere(['channel'=> $gm_channel_result->channel_name,'channel'=>$request['cid']]);
        }
        if(isset($request['source']) && $request['source'] !=''){
            $query->andFilterWhere(['like', 'source', $request['source']]);
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
        return $list=array(0=>$pagination,1=>$result);
    }

    public function channel_name(){
        $db=Yii::$app->db_readonly;
        $sql = 'select `cid`,`channel_name` from `gm_channel_info`';
        $channel_name_list = $db->createCommand($sql)
            ->queryAll();
        return $channel_name_list;
    }
}
