<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SysOplogs;

/**
 * SysOplogsSearch represents the model behind the search form about `app\models\SysOplogs`.
 */
class SysOplogsSearch extends SysOplogs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'opid', 'cid', 'gid'], 'integer'],
            [['keyword', 'logs', 'desc', 'ctime'], 'safe'],
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
        $query = SysOplogs::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'opid' => $this->opid,
            'cid' => $this->cid,
            'gid' => $this->gid,
            'ctime' => $this->ctime,
        ]);

        $query->andFilterWhere(['like', 'keyword', $this->keyword])
            ->andFilterWhere(['like', 'logs', $this->logs])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
    
    public function searchByuid($params)
    {
        $query = SysOplogs::find();
    
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'opid' => Yii::$app->user->id,
            'cid' => $this->cid,
            'gid' => $this->gid,
            'ctime' => $this->ctime,
        ]);
    
        $query->andFilterWhere(['like', 'keyword', $this->keyword])
        ->andFilterWhere(['like', 'logs', $this->logs])
        ->andFilterWhere(['like', 'desc', $this->desc]);
    
        return $dataProvider;
    }
}
