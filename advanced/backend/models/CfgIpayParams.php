<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cfg_ipayParams".
 *
 * @property integer $id
 * @property string $appdesc
 * @property string $appid
 * @property string $privatekey
 * @property string $platkey
 * @property string $ctime
 */
class CfgIpayParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_ipayParams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appdesc', 'appid', 'privatekey', 'platkey'], 'required'],
            [['privatekey', 'platkey'], 'string'],
            [['ctime'], 'safe'],
            [['appdesc', 'appid'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appdesc' => 'Appdesc',
            'appid' => 'Appid',
            'privatekey' => 'Privatekey',
            'platkey' => 'Platkey',
            'ctime' => 'Ctime',
        ];
    }
    
    public static function getIappayDropList(){
        $ar = CfgIpayParams::find()->all();
        return ArrayHelper::map($ar, 'id', 'appdesc');
    }
}
