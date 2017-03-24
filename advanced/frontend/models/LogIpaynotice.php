<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_ipaynotice".
 *
 * @property integer $id
 * @property integer $transtype
 * @property integer $appuserid
 * @property string $cporderid
 * @property string $cpprivate
 * @property string $transid
 * @property string $appid
 * @property integer $feetype
 * @property string $money
 * @property string $currency
 * @property integer $result
 * @property string $transtime
 * @property integer $paytype
 * @property string $Sign
 */
class LogIpaynotice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_ipaynotice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transtype', 'appuserid', 'cporderid', 'cpprivate', 'transid', 'appid', 'feetype', 'money', 'currency', 'result', 'transtime', 'paytype', 'Sign'], 'required'],
            [['transtype', 'appuserid', 'feetype', 'result', 'paytype'], 'integer'],
            [['cporderid', 'cpprivate'], 'string', 'max' => 100],
            [['transid'], 'string', 'max' => 64],
            [['appid', 'transtime'], 'string', 'max' => 20],
            [['money'], 'string', 'max' => 22],
            [['currency'], 'string', 'max' => 32],
            [['Sign'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transtype' => 'Transtype',
            'appuserid' => 'Appuserid',
            'cporderid' => 'Cporderid',
            'cpprivate' => 'Cpprivate',
            'transid' => 'Transid',
            'appid' => 'Appid',
            'feetype' => 'Feetype',
            'money' => 'Money',
            'currency' => 'Currency',
            'result' => 'Result',
            'transtime' => 'Transtime',
            'paytype' => 'Paytype',
            'Sign' => 'Sign',
        ];
    }
}
