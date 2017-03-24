<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgPwdQa;

/**
 * CfgPwdQaSearch represents the model behind the search form about `app\models\CfgPwdQa`.
 */
class CfgPwdQaSearch extends CfgPwdQa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qid'], 'integer'],
            [['q_content', 'ctime'], 'safe'],
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
        $query = CfgPwdQa::find();

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
            'qid' => $this->qid,
            'ctime' => $this->ctime,
        ]);

        $query->andFilterWhere(['like', 'q_content', $this->q_content]);

        return $dataProvider;
    }
}
