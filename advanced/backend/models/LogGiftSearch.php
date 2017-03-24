<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogGift;

/**
 * LogGiftSearch represents the model behind the search form about `app\models\LogGift`.
 */
class LogGiftSearch extends LogGift
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'from_uid', 'to_uid', 'gift_id'], 'integer'],
            [['ctime'], 'safe'],
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
        $query = LogGift::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort'=> ['defaultOrder' =>
                ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'from_uid' => $this->from_uid,
            'to_uid' => $this->to_uid,
        ]);
        if ($this->gift_id!=0 && $this->gift_id!="")
        {
            Yii::error("error : selectgift".$this->gift_id);
            if ($this->gift_id==6){$this->gift_id=11;}
            if ($this->gift_id==5){$this->gift_id=6;}
            $query->andFilterWhere([ 'gift_id'=>$this->gift_id]);
        }

        return $dataProvider;
    }
}
