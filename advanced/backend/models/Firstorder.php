<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "firstorder".
 *
 * @property integer $id
 * @property integer $gid
 * @property string $name
 * @property integer $power
 * @property string $orderid
 * @property string $productid
 * @property string $fee
 * @property string $payType
 * @property string $utime
 */
class Firstorder extends \yii\db\ActiveRecord
{
    public $starttm="";
    public $endtm="";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'firstorder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'power'], 'integer'],
            [['gid', 'orderid', 'productid', 'fee'], 'required'],
            [['utime','reg_time','channel'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['orderid'], 'string', 'max' => 50],
            [['productid'], 'string', 'max' => 30],
            [['fee'], 'string', 'max' => 11],
            [['payType'], 'string', 'max' => 10]
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
            'name' => '昵称',
            'power' => 'VIP等级',
            'orderid' => '订单号',
            'productid' => '产品id',
            'fee' => '金额',
            'payType' => '支付方式',
            'utime' => '更新时间',
            'channel'=>'渠道号',
            'reg_time'=>'注册时间',
        ];
    }
}
