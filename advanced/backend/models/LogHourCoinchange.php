<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_hour_coinchange".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $change_type
 * @property integer $totalchange
 * @property string $chour
 */
class LogHourCoinchange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_hour_coinchange';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'change_type', 'totalchange'], 'integer'],
            [['chour'], 'safe']
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
            'change_type' => '变更类型',
            'totalchange' => '总变更',
            'chour' => '时间',
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
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'gid']);
    }
}
