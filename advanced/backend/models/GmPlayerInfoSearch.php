<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GmPlayerInfo;

/**
 * GmPlayerInfoSearch represents the model behind the search form about `app\models\GmPlayerInfo`.
 */
class GmPlayerInfoSearch extends GmPlayerInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'partner_id', 'sex', 'point', 'money', 'last_login', 'level', 'power', 'charm', 'exploit', 'create_time', 'status', 'point_box', 'max_win'], 'integer'],
            [['name', 'account', 'icon', 'point_pwd', 'sign'], 'safe'],
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
        $query = GmPlayerInfo::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'sort'=> ['defaultOrder' =>
                ['money'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'account_id' => $this->account_id,
            'partner_id' => $this->partner_id,
            'sex' => $this->sex,
            'point' => $this->point,
            'money' => $this->money,
            'last_login' => $this->last_login,
            'level' => $this->level,
            'power' => $this->power,
            'charm' => $this->charm,
            'exploit' => $this->exploit,
            'create_time' => $this->create_time,
            'status' => $this->status,
            'point_box' => $this->point_box,
            'max_win' => $this->max_win,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'account', $this->account])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'point_pwd', $this->point_pwd])
            ->andFilterWhere(['like', 'sign', $this->sign]);

        return $dataProvider;
    }
}
