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
            [['buyer', 'order', 'payment', 'money', 'goods', 'ctime'], 'required'],
            [['buyer', 'money'], 'integer'],
            [['ctime'], 'safe'],
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
            'buyer' => 'Buyer',
            'order' => 'Order',
            'payment' => 'Payment',
            'money' => 'Money',
            'goods' => 'Goods',
            'ctime' => 'Ctime',
        ];
    }
}
