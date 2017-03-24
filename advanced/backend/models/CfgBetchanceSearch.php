<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgBetchance;

/**
 * CfgBetchanceSearch represents the model behind the search form about `app\models\CfgBetchance`.
 */
class CfgBetchanceSearch extends CfgBetchance
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'chance', 'odds'], 'integer'],
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
        $query = CfgBetchance::find();

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
            'chance' => $this->chance,
            'odds' => $this->odds,
        ]);

        return $dataProvider;
    }
}
