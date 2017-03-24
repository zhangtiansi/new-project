<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "top_recharge_client".
 *
 * @property integer $gid
 * @property string $name
 * @property double $ClientFee
 * @property integer $ClientFeeNum
 */
class TopRechargeClient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'top_recharge_client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'ClientFeeNum'], 'integer'],
            [['ClientFee'], 'number'],
            [['name'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'name' => 'Name',
            'ClientFee' => 'Client Fee',
            'ClientFeeNum' => 'Client Fee Num',
        ];
    }
}
