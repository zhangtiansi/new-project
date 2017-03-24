<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "receipt_data".
 *
 * @property integer $id
 * @property integer $player
 * @property string $orderid
 * @property string $productid
 * @property string $data
 * @property string $ctime
 */
class ReceiptData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'receipt_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['player', 'orderid', 'productid', 'data', 'ctime'], 'required'],
            [['player'], 'integer'],
            [['data'], 'string'],
            [['ctime'], 'safe'],
            [['orderid', 'productid'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'player' => 'Player',
            'orderid' => 'Orderid',
            'productid' => 'Productid',
            'data' => 'Data',
            'ctime' => 'Ctime',
        ];
    }
}
