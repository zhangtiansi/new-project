<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "account_view".
 *
 * @property integer $gid
 * @property string $token
 * @property integer $point
 * @property integer $money
 * @property integer $point_box
 * @property integer $total_coin
 * @property integer $level
 * @property integer $power
 * @property integer $win
 * @property integer $lose
 * @property string $account_name
 * @property integer $pwd_q
 * @property string $pwd_a
 * @property string $ime
 * @property string $op_uuid
 * @property string $reg_channel
 * @property string $reg_time
 * @property string $last_login
 * @property integer $account_status
 */
class AccountView extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_view';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'point', 'money', 'point_box', 'total_coin', 'level', 'power', 'win', 'lose', 'pwd_q', 'account_status'], 'integer'],
            [['name', 'account_name', 'pwd_q', 'pwd_a', 'ime', 'op_uuid', 'reg_channel', 'reg_time'], 'required'],
            [['reg_time', 'last_login'], 'safe'],
            [['token', 'pwd_a'], 'string', 'max' => 50],
            [['account_name'], 'string', 'max' => 20],
            [['ime', 'op_uuid'], 'string', 'max' => 100],
            [['reg_channel'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'name' => '昵称',
            'point' => '钻石',
            'money' => '金币',
            'point_box' => '保险箱',
            'total_coin' => '总金币',
            'level' => 'Level',
            'power' => 'VIP等级',
            'win' => '胜场',
            'lose' => '负场',
            'account_name' => '登录账户名',
            'pwd_q' => '密保问题',
            'pwd_a' => '密保答案',
            'ime' => 'Ime号',
            'op_uuid' => 'OpUuid',
            'reg_channel' => '注册渠道',
            'reg_time' => '注册时间',
            'last_login' => '最后登录时间',
            'account_status' => '账户状态',
        ];
    }

    /**
     * @inheritdoc
     * @return AccountViewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccountViewQuery(get_called_class());
    }
}
