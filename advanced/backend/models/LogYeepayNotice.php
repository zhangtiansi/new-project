<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_yeepayNotice".
 *
 * @property integer $id
 * @property string $ptype
 * @property string $orderid
 * @property integer $gid
 * @property string $productid
 * @property string $r0_Cmd
 * @property integer $r1_Code
 * @property string $p1_MerId
 * @property string $p2_Order
 * @property string $p3_Amt
 * @property string $p4_FrpId
 * @property string $p5_CardNo
 * @property string $p6_confirmAmount
 * @property string $p7_realAmount
 * @property string $p8_cardStatus
 * @property string $p9_MP
 * @property string $pb_BalanceAmt
 * @property string $pc_BalanceAct
 * @property string $r2_TrxId
 * @property string $hmac
 * @property string $ctime
 */
class LogYeepayNotice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_yeepayNotice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'orderid', 'gid', 'productid', 'r0_Cmd', 'r1_Code', 'p1_MerId', 'p2_Order', 'p3_Amt', 'p4_FrpId', 'p5_CardNo', 'p6_confirmAmount', 'p7_realAmount', 'p8_cardStatus', 'hmac'], 'required'],
            [['gid', 'r1_Code'], 'integer'],
            [['ctime'], 'safe'],
            [['ptype', 'productid'], 'string', 'max' => 30],
            [['orderid'], 'string', 'max' => 60],
            [['r0_Cmd', 'p2_Order', 'r2_TrxId'], 'string', 'max' => 50],
            [['p1_MerId', 'p3_Amt'], 'string', 'max' => 20],
            [['p4_FrpId'], 'string', 'max' => 30],
            [['p5_CardNo'], 'string', 'max' => 300],
            [['p6_confirmAmount', 'p7_realAmount', 'p8_cardStatus'], 'string', 'max' => 100],
            [['p9_MP'], 'string', 'max' => 200],
            [['pb_BalanceAmt', 'pc_BalanceAct'], 'string', 'max' => 111],
            [['hmac'], 'string', 'max' => 55],
            [['orderid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ptype' => 'Ptype',
            'orderid' => 'Orderid',
            'gid' => 'Gid',
            'productid' => 'Productid',
            'r0_Cmd' => 'R0  Cmd',
            'r1_Code' => 'R1  Code',
            'p1_MerId' => 'P1  Mer ID',
            'p2_Order' => 'P2  Order',
            'p3_Amt' => 'P3  Amt',
            'p4_FrpId' => 'P4  Frp ID',
            'p5_CardNo' => 'P5  Card No',
            'p6_confirmAmount' => 'P6 Confirm Amount',
            'p7_realAmount' => 'P7 Real Amount',
            'p8_cardStatus' => 'P8 Card Status',
            'p9_MP' => 'P9  Mp',
            'pb_BalanceAmt' => 'Pb  Balance Amt',
            'pc_BalanceAct' => 'Pc  Balance Act',
            'r2_TrxId' => 'R2  Trx ID',
            'hmac' => 'Hmac',
            'ctime' => 'Ctime',
        ];
    }
}
