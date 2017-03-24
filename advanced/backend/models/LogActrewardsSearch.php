<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogActrewards;

/**
 * LogActrewardsSearch represents the model behind the search form about `app\models\LogActrewards`.
 */
class LogActrewardsSearch extends LogActrewards
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'point', 'coin', 'propid', 'propnum', 'card_g', 'card_s', 'card_c', 'status'], 'integer'],
            [['ctime', 'change_type', 'desc'], 'safe'],
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
        $query = LogActrewards::find();

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
            'point' => $this->point,
            'coin' => $this->coin,
            'propid' => $this->propid,
            'propnum' => $this->propnum,
            'card_g' => $this->card_g,
            'card_s' => $this->card_s,
            'card_c' => $this->card_c,
            'status' => $this->status,
            'ctime' => $this->ctime,
        ]);

        if ($this->change_type!="" && $this->change_type!=0){
            $query->andFilterWhere(['change_type' => $this->change_type]);
        }

        return $dataProvider;
    }
}
