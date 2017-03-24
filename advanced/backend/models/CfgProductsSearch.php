<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgProducts;

/**
 * CfgProductsSearch represents the model behind the search form about `app\models\CfgProducts`.
 */
class CfgProductsSearch extends CfgProducts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price', 'diamonds', 'vipcard_g', 'vipcard_s', 'vipcard_c', 'product_type'], 'integer'],
            [['product_id', 'product_name', 'product_desc', 'utime'], 'safe'],
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
        $query = CfgProducts::find();

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
            'price' => $this->price,
            'diamonds' => $this->diamonds,
            'vipcard_g' => $this->vipcard_g,
            'vipcard_s' => $this->vipcard_s,
            'vipcard_c' => $this->vipcard_c,
            'utime' => $this->utime,
            'product_type' => $this->product_type,
        ]);

        $query->andFilterWhere(['like', 'product_id', $this->product_id])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_desc', $this->product_desc]);

        return $dataProvider;
    }
}
