<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogHourPlayerinfo;

/**
 * LogHourPlayerinfoSearch represents the model behind the search form about `app\models\LogHourPlayerinfo`.
 */
class LogHourPlayerinfoSearch extends LogHourPlayerinfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'point', 'money', 'level', 'power', 'charm'], 'integer'],
            [['name', 'chour'], 'safe'],
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
        $query = LogHourPlayerinfo::find();

        
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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gid' => $this->gid,
            'point' => $this->point,
            'money' => $this->money,
            'level' => $this->level,
            'power' => $this->power,
            'charm' => $this->charm,
            'chour' => $this->chour,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
