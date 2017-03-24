<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_month_recharge".
 *
 * @property integer $id
 * @property string $c_month
 * @property integer $channel
 * @property string $pay_source
 * @property integer $recharge
 * @property integer $num
 * @property integer $unum
 * @property double $arpu
 * @property double $pay_avg
 */
class DataMonthRecharge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_month_recharge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['c_month', 'channel'], 'required'],
            [['channel', 'recharge', 'num', 'unum'], 'integer'],
            [['arpu', 'pay_avg'], 'number'],
            [['c_month'], 'string', 'max' => 32],
            [['pay_source'], 'string', 'max' => 33]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'c_month' => '月份',
            'channel' => '渠道',
            'pay_source' => '支付方式',
            'recharge' => '总数',
            'num' => '充值笔数',
            'unum' => '充值人数',
            'arpu' => 'Arpu',
            'pay_avg' => '单笔平均',
        ];
    }
}
