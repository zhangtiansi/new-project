<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataMonthRecharge;
use app\models\GmChannelInfo;
use yii\data\Pagination;

/**
 * DataMonthRechargeSearch represents the model behind the search form about `app\models\DataMonthRecharge`.
 */
class DataMonthRechargeSearch extends DataMonthRecharge
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel', 'recharge', 'num', 'unum'], 'integer'],
            [['c_month', 'pay_source'], 'safe'],
            [['arpu', 'pay_avg'], 'number'],
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
        $query = DataMonthRecharge::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['c_month'=>SORT_DESC,'channel'=>SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'recharge' => $this->recharge,
            'num' => $this->num,
            'unum' => $this->unum,
            'arpu' => $this->arpu,
            'pay_avg' => $this->pay_avg,
        ]);
        if ($this->channel!=""&& $this->channel!=0)
        {
            $dplist=GmChannelInfo::getChannelDropList();
            $channelName=$dplist[$this->channel];
            $query->andFilterWhere(['channel'=>GmChannelInfo::findChannelidByName($channelName)]);
            Yii::error("channel filter channelid :".GmChannelInfo::findChannelidByName($channelName));
        }

        $query->andFilterWhere(['like', 'c_month', $this->c_month])
            ->andFilterWhere(['like', 'pay_source', $this->pay_source]);

        return $dataProvider;
    }

    public function new_search($request){
        $query = DataMonthRecharge::find();
        if(isset($request['cid']) && $request['cid'] !=''){
            $query->filterWhere(['channel'=>$request['cid']]);
        }
        if(isset($request['source']) && $request['source'] !=''){
            $query->andFilterWhere(['like', 'pay_source', $request['source']]);
        }
        if(isset($request['pay_time']) && $request['pay_time'] !=''){
            $new_pay_time = substr($request['pay_time'],0,7);
            $query->andFilterWhere(['c_month' => $new_pay_time]);
        }
        $query->orderBy(['id' => SORT_DESC]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);

        $result = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        foreach($result as $key=>$value){
                $channel_result = GmChannelInfo::find()->where(['cid'=>$value->channel])->one();
                $result[$key]['channel'] = $channel_result->channel_name;
            }
        return $list = array(0=>$result,1=>$pagination,2=>$count);
        }
}
