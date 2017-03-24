<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gameweightlist".
 *
 * @property integer $win_uid
 * @property string $win_coin
 * @property integer $ct
 * @property string $totalweight
 * @property string $avg_weight
 * @property integer $power
 * @property integer $money
 * @property integer $status
 * @property string $reg_channel
 * @property string $last_login
 * @property string $gamePlay
 * @property integer $game_win
 */
class Gameweightlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gameweightlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['win_uid', 'reg_channel'], 'required'],
            [['win_uid', 'ct', 'power', 'money', 'status', 'gamePlay', 'game_win'], 'integer'],
            [['win_coin', 'totalweight', 'avg_weight'], 'number'],
            [['last_login'], 'safe'],
            [['reg_channel'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'win_uid' => '玩家ID',
            'win_coin' => '赢取金币数',
            'ct' => '总局数',
            'totalweight' => '总新号权重(越高越有嫌疑)',
            'avg_weight' => '平均每场权重',
            'power' => 'VIP等级',
            'money' => '身上金币',
            'status' => '帐号状态',
            'reg_channel' => '注册渠道',
            'last_login' => '最后登录时间',
            'gamePlay' => '总局数',
            'game_win' => '总赢场',
        ];
    }
    public function getPlayer()
    {//一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'win_uid']);
    }
    public function getAccount()
    {//一对一
        return $this->hasOne(GmAccountInfo::className(), ['gid' => 'win_uid']);
    }
}
