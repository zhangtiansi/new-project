<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccountView;

/**
 * GmAccountInfoSearch represents the model behind the search form about `app\models\GmAccountInfo`.
 */
class AccountViewSearch extends AccountView
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'point', 'money', 'point_box', 'total_coin', 'level', 'power', 'win', 'lose', 'pwd_q', 'account_status'], 'integer'],
            [['name', 'account_name', 'pwd_q', 'pwd_a', 'ime', 'op_uuid', 'reg_channel', 'reg_time','reg_time', 'last_login'], 'safe'],
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
        $query = AccountView::find();
        
        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'sort'=> ['defaultOrder' =>
                ['total_coin'=>SORT_DESC]]
        ]);
        if(!empty($params)){
        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gid' => $this->gid,
        ]);

        $query->andFilterWhere(['like', 'account_name', $this->account_name])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'ime', $this->ime]);
        }else {
            $query->andFilterWhere([
                'gid' => 1,
            ]); 
        }
        return $dataProvider;
    }
}
