<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataDailyCoinchange;

/**
 * DataDailyCoinchangeSearch represents the model behind the search form about `app\models\DataDailyCoinchange`.
 */
class DataDailyCoinchangeSearch extends DataDailyCoinchange
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'change_type', 'sum_coin'], 'integer'],
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
        $query = DataDailyCoinchange::find();

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
            'udate' => $this->udate,
            'sum_coin' => $this->sum_coin,
        ]);
        if ($this->change_type!="" && $this->change_type!=0){
            $query->andFilterWhere(['change_type' => $this->change_type]);
        }
        return $dataProvider;
    }
}
