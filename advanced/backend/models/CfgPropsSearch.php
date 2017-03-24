<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgProps;

/**
 * CfgPropsSearch represents the model behind the search form about `app\models\CfgProps`.
 */
class CfgPropsSearch extends CfgProps
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'prop_cost', 'cost_type', 'prop_type', 'charm', 'change'], 'integer'],
            [['prop_name', 'utime'], 'safe'],
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
        $query = CfgProps::find();

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
            'prop_cost' => $this->prop_cost,
            'cost_type' => $this->cost_type,
            'utime' => $this->utime,
            'prop_type' => $this->prop_type,
            'charm' => $this->charm,
            'change' => $this->change,
        ]);

        $query->andFilterWhere(['like', 'prop_name', $this->prop_name]);

        return $dataProvider;
    }
}
