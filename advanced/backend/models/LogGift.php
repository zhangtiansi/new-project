<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_gift".
 *
 * @property integer $id
 * @property integer $from_uid
 * @property integer $to_uid
 * @property integer $gift_id
 * @property string $ctime
 * @property integer $gift_num
 * @property string $from_name
 */
class LogGift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_gift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_uid', 'to_uid', 'gift_id', 'ctime', 'from_name'], 'required'],
            [['from_uid', 'to_uid', 'gift_id', 'gift_num'], 'integer'],
            [['ctime'], 'safe'],
            [['from_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_uid' => '赠送用户',
            'to_uid' => '获赠用户',
            'gift_id' => '礼品名称',
            'ctime' => '时间',
            'gift_num' => '礼品数量',
            'from_name' => 'From Name',
        ];
    }
    public function getGift()
    {//一对一
        return $this->hasOne(CfgProps::className(), ['id' => 'gift_id']);
    }
    public function getFromplayer()
    {//一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'from_uid']);
    }
    public function getToplayer()
    {//一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'to_uid']);
    }
}
