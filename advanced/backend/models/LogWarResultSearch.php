<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogWarResult;

/**
 * LogWarResultSearch represents the model behind the search form about `app\models\LogWarResult`.
 */
class LogWarResultSearch extends LogWarResult
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['war_id', 'men_1', 'men_2', 'men_3', 'men_4', 'banker'], 'integer'],
            [['men_card_1', 'men_card_2', 'men_card_3', 'men_card_4', 'ctme', 'banker_card'], 'safe'],
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
        $query = LogWarResult::find();

        $dataProvider = new ActiveDataProvider([
             'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['war_id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'war_id' => $this->war_id,
            'men_1' => $this->men_1,
            'men_2' => $this->men_2,
            'men_3' => $this->men_3,
            'men_4' => $this->men_4,
            'ctme' => $this->ctme,
            'banker' => $this->banker,
        ]);

        $query->andFilterWhere(['like', 'men_card_1', $this->men_card_1])
            ->andFilterWhere(['like', 'men_card_2', $this->men_card_2])
            ->andFilterWhere(['like', 'men_card_3', $this->men_card_3])
            ->andFilterWhere(['like', 'men_card_4', $this->men_card_4])
            ->andFilterWhere(['like', 'banker_card', $this->banker_card]);

        return $dataProvider;
    }
}
