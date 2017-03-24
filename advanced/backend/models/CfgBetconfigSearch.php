<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgBetconfig;

/**
 * CfgBetconfigSearch represents the model behind the search form about `app\models\CfgBetconfig`.
 */
class CfgBetconfigSearch extends CfgBetconfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'min_num', 'max_num', 'ntime', 'num_yu', 'num_coin', 'bidnow'], 'integer'],
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
        $query = CfgBetconfig::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'min_num' => $this->min_num,
            'max_num' => $this->max_num,
            'ntime' => $this->ntime,
            'num_yu' => $this->num_yu,
            'num_coin' => $this->num_coin,
            'bidnow' => $this->bidnow,
        ]);

        return $dataProvider;
    }
}
