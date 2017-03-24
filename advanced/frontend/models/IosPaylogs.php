<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ios_paylogs".
 *
 * @property integer $id
 * @property string $receipt
 * @property integer $status
 * @property string $original_purchase_date_pst
 * @property string $purchase_date_ms
 * @property string $unique_identifier
 * @property string $original_transaction_id
 * @property string $bvrs
 * @property string $transaction_id
 * @property string $quantity
 * @property string $unique_vendor_identifier
 * @property string $item_id
 * @property string $product_id
 * @property string $purchase_date
 * @property string $original_purchase_date
 * @property string $purchase_date_pst
 * @property string $bid
 * @property string $original_purchase_date_ms
 * @property string $purchase_time
 * @property string $create_time
 * @property integer $player
 * @property string $orderid
 */
class IosPaylogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ios_paylogs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receipt', 'status', 'create_time'], 'required'],
            [['receipt'], 'string'],
            [['status', 'player'], 'integer'],
            [['purchase_time', 'create_time'], 'safe'],
            [['original_purchase_date_pst', 'transaction_id', 'orderid'], 'string', 'max' => 80],
            [['purchase_date_ms', 'original_transaction_id', 'bid'], 'string', 'max' => 30],
            [['unique_identifier', 'purchase_date', 'original_purchase_date', 'purchase_date_pst'], 'string', 'max' => 50],
            [['bvrs'], 'string', 'max' => 10],
            [['quantity'], 'string', 'max' => 6],
            [['unique_vendor_identifier', 'product_id'], 'string', 'max' => 60],
            [['item_id', 'original_purchase_date_ms'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'receipt' => 'Receipt',
            'status' => 'Status',
            'original_purchase_date_pst' => 'Original Purchase Date Pst',
            'purchase_date_ms' => 'Purchase Date Ms',
            'unique_identifier' => 'Unique Identifier',
            'original_transaction_id' => 'Original Transaction ID',
            'bvrs' => 'Bvrs',
            'transaction_id' => 'Transaction ID',
            'quantity' => 'Quantity',
            'unique_vendor_identifier' => 'Unique Vendor Identifier',
            'item_id' => 'Item ID',
            'product_id' => 'Product ID',
            'purchase_date' => 'Purchase Date',
            'original_purchase_date' => 'Original Purchase Date',
            'purchase_date_pst' => 'Purchase Date Pst',
            'bid' => 'Bid',
            'original_purchase_date_ms' => 'Original Purchase Date Ms',
            'purchase_time' => 'Purchase Time',
            'create_time' => 'Create Time',
            'player' => 'Player',
            'orderid' => 'Orderid',
        ];
    }
}
