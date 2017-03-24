<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgIpayParams;

/**
 * CfgIpayParamsSearch represents the model behind the search form about `app\models\CfgIpayParams`.
 */
class CfgIpayParamsSearch extends CfgIpayParams
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['appdesc', 'appid', 'privatekey', 'platkey', 'ctime'], 'safe'],
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
        $query = CfgIpayParams::find();

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
            'ctime' => $this->ctime,
        ]);

        $query->andFilterWhere(['like', 'appdesc', $this->appdesc])
            ->andFilterWhere(['like', 'appid', $this->appid])
            ->andFilterWhere(['like', 'privatekey', $this->privatekey])
            ->andFilterWhere(['like', 'platkey', $this->platkey]);

        return $dataProvider;
    }
}
