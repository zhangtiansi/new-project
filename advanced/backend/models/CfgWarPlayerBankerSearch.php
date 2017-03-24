<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgWarPlayerBanker;

/**
 * CfgWarPlayerBankerSearch represents the model behind the search form about `app\models\CfgWarPlayerBanker`.
 */
class CfgWarPlayerBankerSearch extends CfgWarPlayerBanker
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'men_1', 'men_2', 'men_3', 'men_4', 'men_5', 'b_open'], 'integer'],
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
        $query = CfgWarPlayerBanker::find();

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
            'men_1' => $this->men_1,
            'men_2' => $this->men_2,
            'men_3' => $this->men_3,
            'men_4' => $this->men_4,
            'men_5' => $this->men_5,
            'b_open' => $this->b_open,
        ]);

        return $dataProvider;
    }
}
