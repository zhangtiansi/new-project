<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "agent_info".
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $agent_name
 * @property integer $money
 * @property integer $status
 * @property string $agent_desc
 */
class AgentInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agent_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'agent_name', 'money', 'agent_desc'], 'required'],
            [['account_id', 'money', 'status'], 'integer'],
            [['agent_name'], 'string', 'max' => 30],
            [['agent_desc'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => '登录帐号',
            'agent_name' => 'Agent名称',
            'money' => '余额',
            'status' => '状态',
            'agent_desc' => 'Agent信息描述',
        ];
    }
    public function getAccount()
    {//一对一
        return $this->hasOne(User::className(), ['id' => 'account_id']);
    }
}
