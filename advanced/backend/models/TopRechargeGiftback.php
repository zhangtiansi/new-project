<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "top_recharge_giftback".
 *
 * @property integer $gid
 * @property string $XiancaoBack
 * @property integer $XiancaoBackNum
 */
class TopRechargeGiftback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'top_recharge_giftback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'XiancaoBackNum'], 'integer'],
            [['XiancaoBack'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'XiancaoBack' => 'Xiancao Back',
            'XiancaoBackNum' => 'Xiancao Back Num',
        ];
    }
}
