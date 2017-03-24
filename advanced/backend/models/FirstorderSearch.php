<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Firstorder;

/**
 * GmAccountInfoSearch represents the model behind the search form about `app\models\GmAccountInfo`.
 */
class FirstorderSearch extends Firstorder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['id', 'gid', 'power'], 'integer'],
            [['utime','gid', 'orderid', 'productid','payType','reg_time','channel',  'starttm','endtm','fee'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['orderid'], 'string', 'max' => 50],
            [['productid'], 'string', 'max' => 30],
            [['fee'], 'string', 'max' => 11],
            [['payType'], 'string', 'max' => 10]
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
        $query = Firstorder::find();

        $dataProvider = new ActiveDataProvider([
//             'db'=>Yii::$app->db_readonly,
            'query' => $query,
            'sort'=> ['defaultOrder' =>
                ['utime'=>SORT_DESC]]
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
        if ($this->starttm !="" )
        {
            $query->andFilterWhere(['>=', 'utime', $this->starttm." 00:00:00"]);
        }
        if ($this->endtm !="" )
        {
            $query->andFilterWhere(['<=', 'utime', $this->endtm." 23:59:59"]);
        }
        $query->andFilterWhere(['like', 'payType', $this->payType])
        ->andFilterWhere(['like', 'fee', $this->fee])
        ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
