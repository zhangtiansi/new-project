<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogHourCoinchange;

/**
 * LogHourCoinchangeSearch represents the model behind the search form about `app\models\LogHourCoinchange`.
 */
class LogHourCoinchangeSearch extends LogHourCoinchange
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'change_type', 'totalchange'], 'integer'],
            [['chour'], 'safe'],
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
        $query = LogHourCoinchange::find();

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
            'change_type' => $this->change_type,
            'totalchange' => $this->totalchange,
            'chour' => $this->chour,
        ]);

        return $dataProvider;
    }
}
