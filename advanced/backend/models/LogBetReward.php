<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_bet_reward".
 *
 * @property integer $id
 * @property integer $bid
 * @property integer $bettype
 * @property integer $gid
 * @property integer $reward
 * @property string $ctime
 * @property integer $status
 */
class LogBetReward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_bet_reward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bid', 'bettype', 'gid', 'reward', 'ctime'], 'required'],
            [['bid', 'bettype', 'gid', 'reward', 'status'], 'integer'],
            [['ctime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bid' => '时时乐场次id',
            'bettype' => '中奖类型',
            'gid' => '玩家UID',
            'reward' => '中奖金额',
            'ctime' => '时间',
            'status' => 'Status',
        ];
    }
}
