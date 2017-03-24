<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_carconfig".
 *
 * @property integer $id
 * @property string $name
 * @property integer $vip
 * @property integer $price
 */
class CfgCarconfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_carconfig';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'vip', 'price'], 'required'],
            [['vip', 'price'], 'integer'],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'vip' => 'Vip',
            'price' => 'Price',
        ];
    }
}
