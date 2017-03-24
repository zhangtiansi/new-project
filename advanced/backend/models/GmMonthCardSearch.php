<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GmMonthCard;

/**
 * GmMonthCardSearch represents the model behind the search form about `app\models\GmMonthCard`.
 */
class GmMonthCardSearch extends GmMonthCard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'firstbg_tm', 'buy_tm'], 'integer'],
            [['lastbuy_tm', 'lastget_tm'], 'safe'],
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
        $query = GmMonthCard::find();

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
            'gid' => $this->gid,
            'firstbg_tm' => $this->firstbg_tm,
            'buy_tm' => $this->buy_tm,
            'lastbuy_tm' => $this->lastbuy_tm,
            'lastget_tm' => $this->lastget_tm,
        ]);

        return $dataProvider;
    }
}
