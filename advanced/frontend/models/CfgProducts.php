<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_products".
 *
 * @property integer $id
 * @property string $product_id
 * @property string $product_name
 * @property string $product_desc
 * @property integer $price
 * @property integer $diamonds
 * @property integer $vipcard_g
 * @property integer $vipcard_s
 * @property integer $vipcard_c
 * @property string $utime
 * @property integer $product_type
 */
class CfgProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'product_name', 'product_desc', 'price', 'diamonds', 'utime', 'product_type'], 'required'],
            [['diamonds', 'vipcard_g', 'vipcard_s', 'vipcard_c', 'product_type'], 'integer'],
            [['utime','price','coin','card_kick','card_laba','card_rename'], 'safe'],
            [['product_id'], 'string', 'max' => 20],
            [['product_name', 'product_desc'], 'string', 'max' => 50],
            [['product_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'product_desc' => 'Product Desc',
            'price' => 'Price',
            'diamonds' => 'Diamonds',
            'coin'=>'金币数',
            'card_kick'=>'踢人卡',
            'card_laba'=>'喇叭卡',
            'card_rename'=>'改名卡',
            'vipcard_g' => 'Vipcard G',
            'vipcard_s' => 'Vipcard S',
            'vipcard_c' => 'Vipcard C',
            'utime' => 'Utime',
            'product_type' => 'Product Type',
        ];
    }
}
