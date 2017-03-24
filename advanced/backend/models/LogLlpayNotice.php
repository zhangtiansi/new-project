<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_llpayNotice".
 *
 * @property integer $id
 * @property integer $gid
 * @property string $orderid
 * @property string $oid_partner
 * @property string $dt_order
 * @property string $no_order
 * @property string $oid_paybill
 * @property string $money_order
 * @property string $result_pay
 * @property string $settle_date
 * @property string $info_order
 * @property string $pay_type
 * @property integer $bank_code
 * @property string $no_agree
 * @property string $id_type
 * @property string $id_no
 * @property string $acct_name
 * @property string $sign_type
 * @property string $sign
 * @property string $ctime
 */
class LogLlpayNotice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_llpayNotice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'orderid', 'oid_partner', 'dt_order', 'no_order', 'oid_paybill', 'money_order', 'result_pay', 'pay_type', 'id_type', 'id_no', 'acct_name', 'sign_type'], 'required'],
            [['gid', 'bank_code'], 'integer'],
            [['ctime'], 'safe'],
            [['orderid', 'info_order', 'no_agree', 'id_no'], 'string', 'max' => 50],
            [['oid_partner', 'no_order'], 'string', 'max' => 51],
            [['dt_order'], 'string', 'max' => 31],
            [['oid_paybill'], 'string', 'max' => 200],
            [['money_order'], 'string', 'max' => 100],
            [['result_pay', 'settle_date', 'acct_name', 'sign_type'], 'string', 'max' => 20],
            [['pay_type'], 'string', 'max' => 10],
            [['id_type'], 'string', 'max' => 5],
            [['sign'], 'string', 'max' => 255]
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
            'orderid' => 'Orderid',
            'oid_partner' => 'Oid Partner',
            'dt_order' => 'Dt Order',
            'no_order' => 'No Order',
            'oid_paybill' => 'Oid Paybill',
            'money_order' => 'Money Order',
            'result_pay' => 'Result Pay',
            'settle_date' => 'Settle Date',
            'info_order' => 'Info Order',
            'pay_type' => 'Pay Type',
            'bank_code' => 'Bank Code',
            'no_agree' => 'No Agree',
            'id_type' => 'Id Type',
            'id_no' => 'Id No',
            'acct_name' => 'Acct Name',
            'sign_type' => 'Sign Type',
            'sign' => 'Sign',
            'ctime' => 'Ctime',
        ];
    }
}
