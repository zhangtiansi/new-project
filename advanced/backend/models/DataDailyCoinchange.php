<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_daily_coinchange".
 *
 * @property integer $id
 * @property string $udate
 * @property integer $change_type
 * @property integer $sum_coin
 */
class DataDailyCoinchange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_daily_coinchange';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['udate'], 'safe'],
            [['change_type', 'sum_coin'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'udate' => '日期',
            'change_type' => '变更类型',
            'sum_coin' => '总金币数',
        ];
    }
    public function getChangeType()
    {
        //一对一
        return $this->hasOne(CfgCoinChangetype::className(), ['cid' => 'change_type']);
    
    }
}
