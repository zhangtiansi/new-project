<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgVipCard;

/**
 * CfgVipCardSearch represents the model behind the search form about `app\models\CfgVipCard`.
 */
class CfgVipCardSearch extends CfgVipCard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_id', 'card_exp', 'card_cost'], 'integer'],
            [['card_name', 'ctime'], 'safe'],
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
        $query = CfgVipCard::find();

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
            'card_id' => $this->card_id,
            'card_exp' => $this->card_exp,
            'card_cost' => $this->card_cost,
            'ctime' => $this->ctime,
        ]);

        $query->andFilterWhere(['like', 'card_name', $this->card_name]);

        return $dataProvider;
    }
}
