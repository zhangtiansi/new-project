<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_player_flag".
 *
 * @property integer $account_id
 * @property integer $login_time
 * @property integer $sign_num
 * @property integer $sign_mark
 * @property integer $item_index
 * @property integer $win
 * @property integer $lose
 * @property integer $score
 * @property integer $vip_score
 * @property integer $day_reward
 * @property integer $week_reward
 * @property integer $ChangeNameMark
 */
class GmPlayerFlag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_player_flag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id'], 'required'],
            [['account_id', 'login_time', 'sign_num', 'sign_mark', 'item_index', 'win', 'lose', 'score', 'vip_score', 'day_reward', 'week_reward', 'ChangeNameMark'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_id' => 'Account ID',
            'login_time' => 'Login Time',
            'sign_num' => 'Sign Num',
            'sign_mark' => 'Sign Mark',
            'item_index' => 'Item Index',
            'win' => 'Win',
            'lose' => 'Lose',
            'score' => 'Score',
            'vip_score' => 'Vip Score',
            'day_reward' => 'Day Reward',
            'week_reward' => 'Week Reward',
            'ChangeNameMark' => 'Change Name Mark',
        ];
    }
    
}
