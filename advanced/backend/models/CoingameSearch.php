<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "coinall".
 *
 * @property integer $id
 * @property integer $gid
 * @property string $name
 * @property integer $point
 * @property integer $total_coin
 * @property integer $maxCoin
 * @property integer $maxType
 * @property integer $minCoin
 * @property integer $minType
 * @property integer $totalchange
 * @property string $ctime
 * @property integer $regtime
 */
class CoingameSearch extends Coingame
{
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'point','name','ctime', 'total_coin', 'maxCoin', 'totalchange', 'winTime', 'regtime'], 'safe']
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
        $query = Coingame::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'sort'=> ['defaultOrder' =>
                ['ctime'=>SORT_DESC,'totalchange'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gid' => $this->gid,
            'ctime'=>$this->ctime
        ]);
//         $query->andFilterWhere(['like', 'ctime', $this->ctime]);

        return $dataProvider;
    }
}
