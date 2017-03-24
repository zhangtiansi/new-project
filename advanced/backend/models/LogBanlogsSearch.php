<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogBanlogs;

/**
 * LogBanlogsSearch represents the model behind the search form about `app\models\LogBanlogs`.
 */
class LogBanlogsSearch extends LogBanlogs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'ban_type'], 'integer'],
            [['ban_time', 'ban_desc'], 'safe'],
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
        $query = LogBanlogs::find();

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
            'ban_time' => $this->ban_time,
            'ban_type' => $this->ban_type,
        ]);

        $query->andFilterWhere(['like', 'ban_desc', $this->ban_desc]);

        return $dataProvider;
    }
}
