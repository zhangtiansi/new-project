<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_serverlist".
 *
 * @property integer $id
 * @property integer $serverid
 * @property string $servername
 * @property string $serverip
 * @property integer $serverport
 * @property integer $status
 */
class CfgServerlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_serverlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['serverid', 'servername', 'serverip', 'serverport', 'status'], 'required'],
            [['serverid', 'serverport', 'status'], 'integer'],
            [['servername', 'serverip'], 'string', 'max' => 55],
            [['serverid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serverid' => 'Serverid',
            'servername' => 'Servername',
            'serverip' => 'Serverip',
            'serverport' => 'Serverport',
            'status' => 'Status',
        ];
    }
}
