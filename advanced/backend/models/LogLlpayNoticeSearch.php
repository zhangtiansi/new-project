<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogLlpayNotice;

/**
 * LogLlpayNoticeSearch represents the model behind the search form about `app\models\LogLlpayNotice`.
 */
class LogLlpayNoticeSearch extends LogLlpayNotice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'bank_code'], 'integer'],
            [['orderid', 'oid_partner', 'dt_order', 'no_order', 'oid_paybill', 'money_order', 'result_pay', 'settle_date', 'info_order', 'pay_type', 'no_agree', 'id_type', 'id_no', 'acct_name', 'sign_type', 'sign', 'ctime'], 'safe'],
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
        $query = LogLlpayNotice::find();

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
            'id' => $this->id,
            'gid' => $this->gid,
            'bank_code' => $this->bank_code,
            'ctime' => $this->ctime,
        ]);

        $query->andFilterWhere(['like', 'orderid', $this->orderid])
            ->andFilterWhere(['like', 'oid_partner', $this->oid_partner])
            ->andFilterWhere(['like', 'dt_order', $this->dt_order])
            ->andFilterWhere(['like', 'no_order', $this->no_order])
            ->andFilterWhere(['like', 'oid_paybill', $this->oid_paybill])
            ->andFilterWhere(['like', 'money_order', $this->money_order])
            ->andFilterWhere(['like', 'result_pay', $this->result_pay])
            ->andFilterWhere(['like', 'settle_date', $this->settle_date])
            ->andFilterWhere(['like', 'info_order', $this->info_order])
            ->andFilterWhere(['like', 'pay_type', $this->pay_type])
            ->andFilterWhere(['like', 'no_agree', $this->no_agree])
            ->andFilterWhere(['like', 'id_type', $this->id_type])
            ->andFilterWhere(['like', 'id_no', $this->id_no])
            ->andFilterWhere(['like', 'acct_name', $this->acct_name])
            ->andFilterWhere(['like', 'sign_type', $this->sign_type])
            ->andFilterWhere(['like', 'sign', $this->sign]);

        return $dataProvider;
    }
}
