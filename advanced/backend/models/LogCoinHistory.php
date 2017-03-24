<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_coin_history".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $coin_box
 * @property integer $change_type
 * @property integer $change_before
 * @property integer $change_coin
 * @property integer $change_after
 * @property string $game_no
 * @property integer $prop_id
 * @property string $ctime
 */
class LogCoinHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_coin_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'change_type', 'change_before', 'change_coin', 'change_after'], 'required'],
            [['uid', 'coin_box', 'change_type', 'change_before', 'change_coin', 'change_after', 'prop_id'], 'integer'],
            [['ctime'], 'safe'],
            [['game_no'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '玩家id',
            'change_type' => '变更类型',
            'change_before' => '变更前',
            'change_coin' => '变更金币',
            'change_after' => '变更后',
            'game_no' => 'Game No',
            'prop_id' => 'Prop ID',
            'ctime' => '时间',
            'coin_box'=>'保险箱金币',
        ];
    }
    public function getChangeType()
    {
        //一对一
        return $this->hasOne(CfgCoinChangetype::className(), ['cid' => 'change_type']);
    
    }
    
    public function getPlayer()
    {
        //一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'uid']);
    }
    public function getDice()
    {
        //一对一
        return $this->hasOne(CfgDiceMen::className(), ['id' => 'prop_id']);
    }
    public function getDicerecord()
    {
        //一对一
        return $this->hasOne(LogDiceReslut::className(), ['bid' => 'game_no']);
    }
    public function getWarrecord()
    {
        return $this->hasOne(LogWarResult::className(), ['war_id' => 'game_no']);
    }
}
