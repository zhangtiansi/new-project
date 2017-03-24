<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_actrewards".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $point
 * @property integer $coin
 * @property integer $propid
 * @property integer $propnum
 * @property integer $card_g
 * @property integer $card_s
 * @property integer $card_c
 * @property integer $status
 * @property string $ctime
 * @property string $change_type
 * @property string $desc
 */
class LogActrewards extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_actrewards';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'ctime'], 'required'],
            [['gid', 'point', 'coin', 'propid', 'propnum', 'card_g', 'card_s', 'card_c', 'status'], 'integer'],
            [['ctime'], 'safe'],
            [['change_type'], 'string', 'max' => 22],
            [['desc'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => 'Gid',
            'point' => '钻石',
            'coin' => '金币',
            'propid' => '道具id',
            'propnum' => '道具数量',
            'card_g' => '金卡',
            'card_s' => '银卡',
            'card_c' => '铜卡',
            'status' => '状态',
            'ctime' => '时间',
            'change_type' => '变更类型',
            'desc' => '描述',
        ];
    }
    
    public function getChangeType()
    {//一对一
        return $this->hasOne(CfgCoinChangetype::className(), ['cid' => 'change_type']);
    }
    public function getPlayer()
    {//一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'gid']);
    }
    public function getAccount()
    {//一对一
        return $this->hasOne(GmAccountInfo::className(), ['gid' => 'gid']);
    }
    
}
