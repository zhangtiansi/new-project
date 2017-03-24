<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_daily_reward".
 *
 * @property integer $id
 * @property integer $day_num
 * @property integer $reward
 * @property string $ctime
 */
class CfgDailyReward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_daily_reward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'day_num', 'reward'], 'required'],
            [['id', 'day_num', 'reward'], 'integer'],
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
            'day_num' => 'Day Num',
            'reward' => 'Reward',
            'ctime' => 'Ctime',
        ];
    }
}
