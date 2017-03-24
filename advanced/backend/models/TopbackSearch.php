<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Topback;

/**
 * This is the model class for table "toprecharge".
 *
 */
class TopbackSearch extends Toprecharge
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'name','TotalFee', 'XiancaoBack', 'TotalCost', 'ClientFee', 'BackendFee', 'XiancaoFee','XiancaoBackNum', 'ClientFeeNum', 'BackendFeeNum', 'XiancaoFeeNum'], 'safe'],
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
        $query = Topback::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'sort'=> ['defaultOrder' =>
                ['TotalCost'=>SORT_ASC]]
        ]
            );

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gid' => $this->gid,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'reg_channel', $this->reg_channel])
            ->andFilterWhere(['like', 'TotalFee', $this->TotalFee])
            ->andFilterWhere(['like', 'XiancaoBack', $this->XiancaoBack])
            ->andFilterWhere(['like', 'TotalCost', $this->TotalCost])
            ->andFilterWhere(['like', 'XiancaoBack', $this->XiancaoBack]);

        return $dataProvider;
    }
}
