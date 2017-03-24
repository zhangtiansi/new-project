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
            'bid' => 'Bid',
            'bettype' => 'Bettype',
            'gid' => 'Gid',
            'reward' => 'Reward',
            'ctime' => 'Ctime',
            'status' => 'Status',
        ];
    }
}
