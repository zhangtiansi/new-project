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
            [['gid','city_id'], 'integer'],
            [['ctime'], 'safe'],
            [['keyword','city','isp'], 'string', 'max' => 30],
            [['osver', 'appver', 'lineNo', 'uuid', 'dev_id', 'request_ip'], 'string', 'max' => 50],
            [['simSerial'], 'string', 'max' =>50],
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
            'keyword' => 'Keyword',
            'osver' => 'Osver',
            'appver' => 'Appver',
            'lineNo' => 'Line No',
            'uuid' => 'Uuid',
            'simSerial' => 'Sim Serial',
            'dev_id' => 'Dev ID',
            'channel' => 'Channel',
            'ctime' => 'Ctime',
            'request_ip' => 'Request Ip',
        ];
    }
}
