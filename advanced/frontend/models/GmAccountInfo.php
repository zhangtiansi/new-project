<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_account_info".
 *
 * @property integer $gid
 * @property string $account_name
 * @property string $account_pwd
 * @property integer $pwd_q
 * @property string $pwd_a
 * @property string $sim_serial
 * @property string $device_id
 * @property string $op_uuid
 * @property integer $type
 * @property string $reg_channel
 * @property string $reg_time
 * @property string $last_login
 * @property string $token
 * @property integer $status
 */
class GmAccountInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_account_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_name', 'account_pwd', 'pwd_q', 'pwd_a', 'sim_serial', 'device_id', 'op_uuid', 'type', 'reg_channel', 'reg_time', 'token'], 'required'],
            [['gid', 'pwd_q', 'type', 'status'], 'integer'],
            [['reg_time', 'last_login'], 'safe'],
            [['account_name'], 'string', 'max' => 80],
            [['account_pwd', 'sim_serial', 'device_id', 'op_uuid'], 'string', 'max' => 100],
            [['pwd_a', 'token'], 'string', 'max' => 50],
            [['reg_channel'], 'string', 'max' => 10],
            [['account_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'account_name' => 'Account Name',
            'account_pwd' => 'Account Pwd',
            'pwd_q' => 'Pwd Q',
            'pwd_a' => 'Pwd A',
            'phone'=>'手机号',
            'sim_serial' => 'Sim Serial',
            'device_id' => 'Device ID',
            'op_uuid' => 'Op Uuid',
            'type' => 'Type',
            'reg_channel' => 'Reg Channel',
            'reg_time' => 'Reg Time',
            'last_login' => 'Last Login',
            'token' => 'Token',
            'status' => 'Status',
        ];
    }
    
    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        if ($insert){
            $mail = new LogMail();
            $mail->gid=$this->gid;
            $mail->title="欢迎赌神大人";
            $mail->content=Yii::$app->params['mailwelcome'];
            $mail->from_id=0;
            $mail->status = 0;
            $mail->ctime = date('Y-m-d H:i:s');    
//             $mail->save();
            if (!$mail->save())
                Yii::error("failed to save welcome mail".print_r($mail->getErrors(),true));
        }else {
            Yii::error("NOT new record");
        }
    }
    
    
    public function encryptPass($pwd)
    {
        return md5(Yii::$app->params['apikey'].$pwd);
    }
    
    
}
