<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GmNotice;

/**
 * GmNoticeSearch represents the model behind the search form about `app\models\GmNotice`.
 */
class GmNoticeSearch extends GmNotice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tag', 'type', 'status'], 'integer'],
            [['name', 'title', 'content', 'content_time', 'tips', 'utime'], 'safe'],
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
        $query = GmNotice::find();

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
            'tag' => $this->tag,
            'type' => $this->type,
            'utime' => $this->utime,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'content_time', $this->content_time])
            ->andFilterWhere(['like', 'tips', $this->tips]);

        return $dataProvider;
    }
}
