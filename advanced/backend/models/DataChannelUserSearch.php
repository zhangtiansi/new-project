<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataChannelUser;

/**
 * DataChannelUserSearch represents the model behind the search form about `app\models\DataChannelUser`.
 */
class DataChannelUserSearch extends DataChannelUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'regactive'], 'integer'],
            [['udate', 'channel', 'activenum'], 'safe'],
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
        $query = DataChannelUser::find();

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
        
        $query->andFilterWhere(['like', 'channel', $this->channel])
            ->andFilterWhere(['like', 'activenum', $this->activenum]);

        return $dataProvider;
    }
}
