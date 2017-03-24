<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "top_recharge_backend".
 *
 * @property integer $gid
 * @property string $BackendFee
 * @property integer $BackendFeeNum
 */
class TopRechargeBackend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'top_recharge_backend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'BackendFeeNum'], 'integer'],
            [['BackendFee'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'BackendFee' => 'Backend Fee',
            'BackendFeeNum' => 'Backend Fee Num',
        ];
    }
}
