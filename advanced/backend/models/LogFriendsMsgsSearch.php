<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogFriendsMsgs;

/**
 * LogFriendsMsgsSearch represents the model behind the search form about `app\models\LogFriendsMsgs`.
 */
class LogFriendsMsgsSearch extends LogFriendsMsgs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'from_uid', 'to_uid', 'type', 'status'], 'integer'],
            [['msg_content', 'ctime'], 'safe'],
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
        $query = LogFriendsMsgs::find();

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
            'id' => $this->id,
            'from_uid' => $this->from_uid,
            'to_uid' => $this->to_uid,
            'type' => $this->type,
            'status' => $this->status,
            'ctime' => $this->ctime,
        ]);

        $query->andFilterWhere(['like', 'msg_content', $this->msg_content]);

        return $dataProvider;
    }
}
