<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogCustomer;

/**
 * LogCustomerSearch represents the model behind the search form about `app\models\LogCustomer`.
 */
class LogCustomerSearch extends LogCustomer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'point', 'coin', 'propid', 'propnum', 'card_g', 'card_s', 'card_c', 'status'], 'integer'],
            [['ctime', 'ops', 'desc'], 'safe'],
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
        $query = LogCustomer::find();

        $dataProvider = new ActiveDataProvider([
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
        $user = User::findIdentity(Yii::$app->user->id);

        if ($user->checkRole(User::ROLE_ADMIN)||$user->checkRole(User::ROLE_AGENT_ADMIN)){
            $query->andFilterWhere([
                'id' => $this->id,
                'gid' => $this->gid,
                'point' => $this->point,
                'coin' => $this->coin,
                'propid' => $this->propid,
                'propnum' => $this->propnum,
                'card_g' => $this->card_g,
                'card_s' => $this->card_s,
                'card_c' => $this->card_c,
                'status' => $this->status,
                'ctime' => $this->ctime,
            ]);
        }else {
            $query->andFilterWhere([
                'id' => $this->id,
                'gid' => $this->gid,
                'point' => $this->point,
                'coin' => $this->coin,
                'propid' => $this->propid,
                'propnum' => $this->propnum,
                'card_g' => $this->card_g,
                'card_s' => $this->card_s,
                'card_c' => $this->card_c,
                'status' => $this->status,
                'ctime' => $this->ctime,
                'ops'=>Yii::$app->user->id,
            ]);
        }
        if ($this->ops!="" && $this->ops!=0){
            $query->andFilterWhere(['ops'=>$this->ops]);
        }
        return $dataProvider;
    }
}
