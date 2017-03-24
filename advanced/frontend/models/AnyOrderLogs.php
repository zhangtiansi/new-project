<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "any_order_logs".
 *
 * @property integer $id
 * @property string $order_id
 * @property string $product_count
 * @property string $amount
 * @property string $pay_status
 * @property string $pay_time
 * @property string $user_id
 * @property string $order_type
 * @property string $game_user_id
 * @property string $server_id
 * @property string $product_name
 * @property string $product_id
 * @property string $private_data
 * @property string $channel_number
 * @property string $sign
 * @property string $source
 * @property string $gm_proid
 * @property string $gm_orderid
 * @property integer $gm_uid
 */
class AnyOrderLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'any_order_logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_count', 'amount', 'pay_status', 'gm_proid', 'gm_orderid', 'gm_uid'], 'required'],
            [['sign', 'source'], 'string'],
            [['gm_uid'], 'integer'],
            [['order_id', 'user_id', 'product_id'], 'string', 'max' => 50],
            [['product_count', 'amount', 'private_data'], 'string', 'max' => 255],
            [['pay_status', 'order_type'], 'string', 'max' => 5],
            [['pay_time'], 'string', 'max' => 20],
            [['game_user_id', 'server_id'], 'string', 'max' => 10],
            [['product_name'], 'string', 'max' => 30],
            [['channel_number'], 'string', 'max' => 15],
            [['gm_proid', 'gm_orderid'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_count' => 'Product Count',
            'amount' => 'Amount',
            'pay_status' => 'Pay Status',
            'pay_time' => 'Pay Time',
            'user_id' => 'User ID',
            'order_type' => 'Order Type',
            'game_user_id' => 'Game User ID',
            'server_id' => 'Server ID',
            'product_name' => 'Product Name',
            'product_id' => 'Product ID',
            'private_data' => 'Private Data',
            'channel_number' => 'Channel Number',
            'sign' => 'Sign',
            'source' => 'Source',
            'gm_proid' => 'Gm Proid',
            'gm_orderid' => 'Gm Orderid',
            'gm_uid' => 'Gm Uid',
        ];
    }
}
