<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CfgVipLevel;

/**
 * CfgVipLevelSearch represents the model behind the search form about `app\models\CfgVipLevel`.
 */
class CfgVipLevelSearch extends CfgVipLevel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_level', 'vip_exp', 'vip_reward'], 'integer'],
            [['ctime'], 'safe'],
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
        $query = CfgVipLevel::find();

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
            'vip_level' => $this->vip_level,
            'vip_exp' => $this->vip_exp,
            'vip_reward' => $this->vip_reward,
            'ctime' => $this->ctime,
        ]);

        return $dataProvider;
    }
}
