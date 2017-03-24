<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alipay_notice_logs".
 *
 * @property integer $id
 * @property string $order
 * @property integer $accid
 * @property string $discount
 * @property integer $payment_type
 * @property string $subject
 * @property string $trade_no
 * @property string $buyer_email
 * @property string $gmt_create
 * @property string $notify_type
 * @property string $quantity
 * @property string $out_trade_no
 * @property string $seller_id
 * @property string $notify_time
 * @property string $body
 * @property string $trade_status
 * @property string $is_total_fee_adjust
 * @property string $total_fee
 * @property string $gmt_payment
 * @property string $seller_email
 * @property string $price
 * @property string $buyer_id
 * @property string $notify_id
 * @property string $use_coupon
 * @property string $sign
 */
class AlipayNoticeLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alipay_notice_logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'accid', 'subject'], 'required'],
            [['accid', 'payment_type'], 'integer'],
            [['gmt_create', 'notify_time', 'gmt_payment'], 'safe'],
            [['order', 'trade_no', 'buyer_email', 'body'], 'string', 'max' => 100],
            [['discount', 'is_total_fee_adjust', 'total_fee', 'price'], 'string', 'max' => 10],
            [['subject', 'buyer_id'], 'string', 'max' => 30],
            [['notify_type', 'trade_status', 'seller_email'], 'string', 'max' => 20],
            [['quantity'], 'string', 'max' => 5],
            [['out_trade_no', 'seller_id', 'use_coupon'], 'string', 'max' => 50],
            [['notify_id'], 'string', 'max' => 60],
            [['sign'], 'string', 'max' => 200],
            [['order', 'trade_no'], 'unique', 'targetAttribute' => ['order', 'trade_no'], 'message' => 'The combination of Order and Trade No has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order' => 'Order',
            'accid' => 'Accid',
            'discount' => 'Discount',
            'payment_type' => 'Payment Type',
            'subject' => 'Subject',
            'trade_no' => 'Trade No',
            'buyer_email' => 'Buyer Email',
            'gmt_create' => 'Gmt Create',
            'notify_type' => 'Notify Type',
            'quantity' => 'Quantity',
            'out_trade_no' => 'Out Trade No',
            'seller_id' => 'Seller ID',
            'notify_time' => 'Notify Time',
            'body' => 'Body',
            'trade_status' => 'Trade Status',
            'is_total_fee_adjust' => 'Is Total Fee Adjust',
            'total_fee' => 'Total Fee',
            'gmt_payment' => 'Gmt Payment',
            'seller_email' => 'Seller Email',
            'price' => 'Price',
            'buyer_id' => 'Buyer ID',
            'notify_id' => 'Notify ID',
            'use_coupon' => 'Use Coupon',
            'sign' => 'Sign',
        ];
    }
}
