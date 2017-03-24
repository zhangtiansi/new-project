<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogFriendadd;

/**
 * LogFriendaddSearch represents the model behind the search form about `app\models\LogFriendadd`.
 */
class LogFriendaddSearch extends LogFriendadd
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'aid_from', 'aid_to', 'type', 'mark'], 'integer'],
            [['from_name', 'to_name'], 'safe'],
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
        $query = LogFriendadd::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'aid_from' => $this->aid_from,
            'aid_to' => $this->aid_to,
            'type' => $this->type,
            'mark' => $this->mark,
        ]);

        $query->andFilterWhere(['like', 'from_name', $this->from_name])
            ->andFilterWhere(['like', 'to_name', $this->to_name]);

        return $dataProvider;
    }
}
