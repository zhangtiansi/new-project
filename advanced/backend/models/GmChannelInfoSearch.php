<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GmChannelInfo;
use yii\data\Pagination;
use app\models\User;

/**
 * GmChannelInfoSearch represents the model behind the search form about `app\models\GmChannelInfo`.
 */
class GmChannelInfoSearch extends GmChannelInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'status', 'force'], 'integer'],
            [['channel_name', 'channel_desc', 'opname', 'oppasswd','any_channel', 'cur_version', 'update_url', 'version_code', 'changelog', 'ctime'], 'safe'],
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
        $query = GmChannelInfo::find();

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
            'cid' => $this->cid,
            'status' => $this->status,
            'force' => $this->force,
            'ctime' => $this->ctime,
        ]);

        $query->andFilterWhere(['like', 'channel_name', $this->channel_name])
            ->andFilterWhere(['like', 'channel_desc', $this->channel_desc])
            ->andFilterWhere(['like', 'opname', $this->opname])
            ->andFilterWhere(['like', 'oppasswd', $this->oppasswd])
            ->andFilterWhere(['like', 'cur_version', $this->cur_version])
            ->andFilterWhere(['like', 'update_url', $this->update_url])
            ->andFilterWhere(['like', 'version_code', $this->version_code])
            ->andFilterWhere(['like', 'changelog', $this->changelog]);

        return $dataProvider;
    }

    public function new_search($request){
        $query = GmChannelInfo::find();
        if(isset($request['channel_name']) && $request['channel_name'] !=''){
            $query->filterWhere(['like', 'channel_name', $request['channel_name']]);
        }
        $query->orderBy(['cid' => SORT_DESC]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);

        $result = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        foreach($result as $key=>$value){
            if(!empty($value->opname)){
                $user_result = User::find()->where(['id'=>trim($value->opname)])->one();
                if($user_result !=''){
                    $result[$key]['opname'] = $user_result->username;
                }
            }
        }
        return $list = array(0=>$result,1=>$pagination,2=>$count);
    }
}
