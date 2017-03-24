<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_activities".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $actid
 * @property string $ctime
 */
class LogActivities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_activities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'actid'], 'required'],
            [['uid', 'actid'], 'integer'],
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
            'uid' => 'Uid',
            'actid' => '活动id',
            'ctime' => '时间',
        ];
    }
    
    public function getAct()
    {//一对一
        return $this->hasOne(GmOptact::className(), ['id' => 'actid']);
    }
    public function getPlayer()
    {//一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'uid']);
    }
    public function getAccount()
    {//一对一
        return $this->hasOne(GmAccountInfo::className(), ['gid' => 'uid']);
    }
}
