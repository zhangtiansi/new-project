<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_userrequst".
 *
 * @property integer $id
 * @property integer $gid
 * @property string $keyword
 * @property string $osver
 * @property string $appver
 * @property string $lineNo
 * @property string $uuid
 * @property string $simSerial
 * @property string $dev_id
 * @property string $channel
 * @property string $ctime
 * @property string $request_ip
 */
class LogUserrequst extends \yii\db\ActiveRecord
{
    public $isdistinct;//筛选过滤gid
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_userrequst';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'keyword', 'uuid', 'dev_id', 'channel', 'request_ip'], 'required'],
            [['gid'], 'integer'],
            [['ctime','isdistinct'], 'safe'],
            [['keyword'], 'string', 'max' => 30],
            [['osver', 'appver', 'lineNo', 'uuid', 'dev_id', 'request_ip'], 'string', 'max' => 50],
            [['simSerial'], 'string', 'max' => 20],
            [['channel'], 'string', 'max' => 21]
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
            'keyword' => '关键字',
            'osver' => '系统版本',
            'appver' => '应用版本',
            'lineNo' => '电话',
            'uuid' => 'Uuid',
            'simSerial' => 'Sim卡序列号',
            'dev_id' => '设备IME号',
            'channel' => '渠道',
            'ctime' => '时间',
            'request_ip' => '客户端Ip',
            'isdistinct'=>'过滤gid'
        ];
    }
    public function getChannelinfo()
    {//一对一
        return $this->hasOne(GmChannelInfo::className(), ['cid' => 'channel']);
    }
    public function getAccountinfo()
    {//一对一
        return $this->hasOne(GmAccountInfo::className(), ['gid' => 'gid']);
    }
    
    public function getPlayer()
    {//一对一
    return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'gid']);
    }
}
