<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "betinfos".
 *
 * @property integer $gid
 * @property integer $bid
 * @property integer $bet_1
 * @property integer $bet_2
 * @property integer $bet_3
 * @property integer $bet_4
 * @property integer $bet_5
 * @property integer $bet_6
 * @property string $betTime
 * @property integer $bettype
 * @property integer $reward
 * @property string $rewardTtime
 */
class Betinfos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'betinfos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'bet_1', 'bet_2', 'bet_3', 'bet_4', 'bet_5', 'bet_6'], 'required'],
            [['gid', 'bid', 'bet_1', 'bet_2', 'bet_3', 'bet_4', 'bet_5', 'bet_6', 'bettype', 'reward'], 'integer'],
            [['bettime'], 'safe'],
            [['rewardtime'], 'string', 'max' => 19]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'bid' => '时时乐场次id',
            'bet_1' => '对子押注（万）',
            'bet_2' => '顺子押注（万）',
            'bet_3' => '金花押注（万）',
            'bet_4' => '顺金押注（万）',
            'bet_5' => '豹子押注（万）',
            'bet_6' => '3A押注（万）',
            'bettime' => '押注时间',
            'bettype' => '开奖类型',
            'reward' => '返奖奖金',
            'rewardtime' => '返奖时间',
        ];
    }
    public function getPlayer()
    {
        //一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'gid']);
    }
}
