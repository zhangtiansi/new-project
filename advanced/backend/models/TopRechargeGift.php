<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "top_recharge_gift".
 *
 * @property integer $gid
 * @property string $XiancaoFee
 * @property integer $XiancaoFeeNum
 */
class TopRechargeGift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'top_recharge_gift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'XiancaoFeeNum'], 'integer'],
            [['XiancaoFee'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'XiancaoFee' => 'Xiancao Fee',
            'XiancaoFeeNum' => 'Xiancao Fee Num',
        ];
    }
}
