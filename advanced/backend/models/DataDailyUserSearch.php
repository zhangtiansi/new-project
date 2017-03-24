<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataDailyUser;
use yii\data\Pagination;

/**
 * DataDailyUserSearch represents the model behind the search form about `app\models\DataDailyUser`.
 */
class DataDailyUserSearch extends DataDailyUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['udate', 'channel', 'totalreg', 'loginp', 'loginnum', 'activenum','regactive','allreg','allregactive','channelname'], 'safe'],
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
        $query = DataDailyUser::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['udate'=>SORT_DESC,'channel'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if ($this->channel!=""&& $this->channel!=0)
        {
            $dplist=GmChannelInfo::getChannelDropList();
            $channelName=$dplist[$this->channel];
            $query->andFilterWhere(['channel'=>GmChannelInfo::findChannelidByName($channelName)]);
            Yii::error("channel filter channelid :".GmChannelInfo::findChannelidByName($channelName));
        }
        $query->andFilterWhere([
            'udate' => $this->udate,
        ]);
        return $dataProvider;
    }
    
    public function searchChannel($params)
    {
        $query = DataDailyUser::find();
    
        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['udate'=>SORT_DESC,'channel'=>SORT_DESC]]
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
            $channel = $c->channel_name;
            $query->andFilterWhere(['channel'=> $channel]);
        }else{
            $query->andFilterWhere(['channel'=> "xxx"]);
        }
        
//         ->andFilterWhere(['like', 'totalreg', $this->totalreg])
//         ->andFilterWhere(['like', 'loginp', $this->loginp])
//         ->andFilterWhere(['like', 'loginnum', $this->loginnum])
//         ->andFilterWhere(['like', 'activenum', $this->activenum])
//         ->andFilterWhere(['like', 'regactive', $this->regactive]);
    
        return $dataProvider;
    }

    public function newSearch($data){
        $query = DataDailyUser::find();
        if(isset($data['pay_time']) && $data['pay_time'] !=''){
            $query->filterWhere(['udate' => $data['pay_time']]);
        }
        if(isset($data['cid']) && $data['cid'] !=''){
            $gm_channel_result = GmChannelInfo::findOne(['cid'=> $data['cid']]);
            $query->andFilterWhere(['channel'=> $gm_channel_result->channel_name]);
        }
        $query->orderBy(['id' => SORT_DESC]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $result = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $result_all = array(0=>$result,1=>$pagination,2=>$count);
        return $result_all;
    }
}
