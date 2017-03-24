<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_coin_price".
 *
 * @property integer $id
 * @property integer $p_name
 * @property integer $p_coin
 * @property integer $p_cost
 * @property integer $p_desc
 * @property string $utime
 */
class CfgCoinPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_coin_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_name', 'p_coin', 'p_cost', 'p_desc', 'utime'], 'required'],
            [['p_name', 'p_coin', 'p_cost', 'p_desc'], 'integer'],
            [['utime'], 'safe'],
            [['p_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'p_name' => 'P Name',
            'p_coin' => 'P Coin',
            'p_cost' => 'P Cost',
            'p_desc' => 'P Desc',
            'utime' => 'Utime',
        ];
    }
}
