<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_td_summary".
 *
 * @property integer $id
 * @property string $cdate
 * @property integer $reg_num
 * @property integer $login_num
 * @property integer $active_num
 * @property integer $regact_num
 * @property integer $recharge_total
 * @property integer $recharge_num
 * @property integer $agent_cash
 * @property integer $max_online
 * @property integer $now_online
 * @property string $utime
 * @property integer $ssl_bet
 * @property integer $ssl_reward
 * @property integer $ssl_pool
 */
class DataTdSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_td_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cdate', 'utime'], 'safe'],
            [['reg_num', 'login_num', 'active_num', 'regact_num', 'recharge_total', 'recharge_num', 'agent_cash', 'max_online', 'now_online', 'ssl_bet', 'ssl_reward', 'ssl_pool'], 'integer'],
            [['cdate'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cdate' => 'Cdate',
            'reg_num' => 'Reg Num',
            'login_num' => 'Login Num',
            'active_num' => 'Active Num',
            'regact_num' => 'Regact Num',
            'recharge_total' => 'Recharge Total',
            'recharge_num' => 'Recharge Num',
            'agent_cash' => 'Agent Cash',
            'max_online' => 'Max Online',
            'now_online' => 'Now Online',
            'utime' => 'Utime',
            'ssl_bet' => 'Ssl Bet',
            'ssl_reward' => 'Ssl Reward',
            'ssl_pool' => 'Ssl Pool',
        ];
    }
}
