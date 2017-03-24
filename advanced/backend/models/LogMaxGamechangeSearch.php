<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogMaxGamechange;

/**
 * LogMaxGamechangeSearch represents the model behind the search form about `app\models\LogMaxGamechange`.
 */
class LogMaxGamechangeSearch extends LogMaxGamechange
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'coin', 'totalchange', 'play_time'], 'integer'],
            [['ctime'], 'safe'],
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
        $query = LogMaxGamechange::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'coin' => $this->coin,
            'totalchange' => $this->totalchange,
            'ctime' => $this->ctime,
            'play_time' => $this->play_time,
        ]);

        return $dataProvider;
    }
}
