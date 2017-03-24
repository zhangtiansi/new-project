<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogUserrequst;

/**
 * LogUserrequstSearch represents the model behind the search form about `app\models\LogUserrequst`.
 */
class LogUserrequstSearch extends LogUserrequst
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid'], 'integer'],
            [['keyword', 'osver', 'appver', 'lineNo', 'uuid', 'simSerial', 'dev_id', 'channel', 'ctime', 'request_ip','isdistinct'], 'safe'],
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
        $query = LogUserrequst::find();

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
            'gid' => $this->gid,
            'ctime' => $this->ctime,
        ]);
        
        $query->andFilterWhere(['like', 'keyword', $this->keyword])
            ->andFilterWhere(['like', 'osver', $this->osver])
            ->andFilterWhere(['like', 'appver', $this->appver])
            ->andFilterWhere(['like', 'lineNo', $this->lineNo])
            ->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'simSerial', $this->simSerial])
            ->andFilterWhere(['like', 'dev_id', $this->dev_id])
            ->andFilterWhere(['like', 'request_ip', $this->request_ip]);
        if ($this->channel!=""&& $this->channel!=0)
        {
            $dplist=GmChannelInfo::getChannelDropList();
            Yii::error("channel dropdown list :".print_r($dplist,true));
            $channelName=$dplist[$this->channel];
            $query->andFilterWhere(['channel'=>GmChannelInfo::findChannelidByName($channelName)]);
        }
        return $dataProvider;
    }
}
