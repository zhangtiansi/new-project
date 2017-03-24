<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ttszp;

/**
 * TtszpSearch represents the model behind the search form about `app\models\Ttszp`.
 */
class TtszpSearch extends Ttszp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'buyer', 'money'], 'integer'],
            [['order', 'payment', 'goods', 'ctime'], 'safe'],
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
        $query = Ttszp::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['id'=>SORT_DESC ]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'buyer' => $this->buyer,
            'money' => $this->money,
            'ctime' => $this->ctime,
        ]);

        $query->andFilterWhere(['like', 'order', $this->order])
            ->andFilterWhere(['like', 'payment', $this->payment])
            ->andFilterWhere(['like', 'goods', $this->goods]);

        return $dataProvider;
    }
}
