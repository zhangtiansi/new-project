<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgCoinPrice;

/**
 * CfgCoinPriceSearch represents the model behind the search form about `app\models\CfgCoinPrice`.
 */
class CfgCoinPriceSearch extends CfgCoinPrice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'p_name', 'p_coin', 'p_cost', 'p_desc'], 'integer'],
            [['utime'], 'safe'],
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
        $query = CfgCoinPrice::find();

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
            'p_name' => $this->p_name,
            'p_coin' => $this->p_coin,
            'p_cost' => $this->p_cost,
            'p_desc' => $this->p_desc,
            'utime' => $this->utime,
        ]);

        return $dataProvider;
    }
}
