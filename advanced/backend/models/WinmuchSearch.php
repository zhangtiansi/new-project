<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Winmuch;

/**
 * GmAccountInfoSearch represents the model behind the search form about `app\models\GmAccountInfo`.
 */
class WinmuchSearch extends Winmuch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'power', 'money', 'win', 'lose'], 'integer'],
            [['gid', 'power', 'money', 'win', 'lose','reg_channel', 'reg_time','last_login'], 'safe'],
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
        $query = Winmuch::find();

        $dataProvider = new ActiveDataProvider([
            'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'sort'=> ['defaultOrder' =>
                ['last_login'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gid' => $this->gid,
        ]);

        $query->andFilterWhere(['like', 'reg_channel', $this->reg_channel]) ;

        return $dataProvider;
    }
}
