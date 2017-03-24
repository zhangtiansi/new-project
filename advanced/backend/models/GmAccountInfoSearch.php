<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GmAccountInfo;

/**
 * GmAccountInfoSearch represents the model behind the search form about `app\models\GmAccountInfo`.
 */
class GmAccountInfoSearch extends GmAccountInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'pwd_q', 'type', 'status'], 'integer'],
            [['account_name', 'account_pwd', 'pwd_a', 'sim_serial', 'device_id', 'op_uuid', 'reg_channel', 'reg_time', 'last_login', 'token'], 'safe'],
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
        $query = GmAccountInfo::find();

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
            'pwd_q' => $this->pwd_q,
            'type' => $this->type,
            'reg_time' => $this->reg_time,
            'last_login' => $this->last_login,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'account_name', $this->account_name])
            ->andFilterWhere(['like', 'account_pwd', $this->account_pwd])
            ->andFilterWhere(['like', 'pwd_a', $this->pwd_a])
            ->andFilterWhere(['like', 'sim_serial', $this->sim_serial])
            ->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['like', 'op_uuid', $this->op_uuid])
            ->andFilterWhere(['like', 'reg_channel', $this->reg_channel])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
