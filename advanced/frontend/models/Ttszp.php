<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ttszp".
 *
 * @property integer $id
 * @property integer $buyer
 * @property string $order
 * @property string $payment
 * @property integer $money
 * @property string $goods
 * @property string $ctime
 */
class Ttszp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ttszp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['buyer'], 'required'],
            [['buyer', 'money'], 'integer'],
            [['ctime', 'order', 'payment', 'money', 'goods', 'ctime'], 'safe'],
            [['order', 'goods'], 'string', 'max' => 50],
            [['payment'], 'string', 'max' => 22]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'buyer' => '玩家id',
            'order' => '订单号',
            'payment' => '支付类型',
            'money' => 'RMB',
            'goods' => '商品',
            'ctime' => '时间',
        ];
    }
}
