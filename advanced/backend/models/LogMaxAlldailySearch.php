<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogMaxAlldaily;

/**
 * LogMaxAlldailySearch represents the model behind the search form about `app\models\LogMaxAlldaily`.
 */
class LogMaxAlldailySearch extends LogMaxAlldaily
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'maxCoin', 'maxType', 'minType', 'minCoin', 'totalchange'], 'integer'],
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
        $query = LogMaxAlldaily::find();

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
            'maxCoin' => $this->maxCoin,
            'maxType' => $this->maxType,
            'minType' => $this->minType,
            'minCoin' => $this->minCoin,
            'totalchange' => $this->totalchange,
            'ctime' => $this->ctime,
        ]);

        return $dataProvider;
    }
}
