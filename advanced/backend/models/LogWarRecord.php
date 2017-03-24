<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_war_record".
 *
 * @property integer $war_id
 * @property integer $men1_coin
 * @property integer $men1_prize
 * @property integer $men2_coin
 * @property integer $men2_prize
 * @property integer $men3_coin
 * @property integer $men3_prize
 * @property integer $men4_coin
 * @property integer $men4_prize
 * @property integer $banker_id
 * @property integer $banker_coin
 * @property string $ctime
 */
class LogWarRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_war_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['war_id', 'men1_coin', 'men1_prize', 'men2_coin', 'men2_prize', 'men3_coin', 'men3_prize', 'men4_coin', 'men4_prize', 'banker_id', 'banker_coin'], 'required'],
            [['war_id', 'men1_coin', 'men1_prize', 'men2_coin', 'men2_prize', 'men3_coin', 'men3_prize', 'men4_coin', 'men4_prize', 'banker_id', 'banker_coin'], 'integer'],
            [['ctime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'war_id' => 'War ID',
            'men1_coin' => 'Men1押注',
            'men1_prize' => 'Men1返奖',
            'men2_coin' => 'Men2押注',
            'men2_prize' => 'Men2返奖',
            'men3_coin' => 'Men3押注',
            'men3_prize' => 'Men3返奖',
            'men4_coin' => 'Men4押注',
            'men4_prize' => 'Men4返奖',
            'banker_id' => '庄ID',
            'banker_coin' => '庄盈利',
            'ctime' => '时间',
        ];
    }
    
    public function getCards()
    {
        return $this->hasOne(LogWarResult::className(), ['war_id' => 'war_id']);
    }
    public function getBanker()
    {
        //一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'banker_id']);
    }
}
