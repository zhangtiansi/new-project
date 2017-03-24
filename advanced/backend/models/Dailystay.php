<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_dailystay".
 *
 * @property integer $id
 * @property string $udate
 * @property integer $channel
 * @property integer $r_num
 * @property integer $s_num2
 * @property integer $s_num3
 * @property integer $s_num7
 */
class Dailystay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_dailystay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['udate', 'channel', 'r_num', 's_num2', 's_num3', 's_num7'], 'required'],
            [['udate'], 'safe'],
            [['channel', 'r_num', 's_num2', 's_num3', 's_num7'], 'integer']
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
            'channel' => '渠道',
            'r_num' => '注册活跃',
            's_num2' => '次留',
            's_num3' => '3日留存',
            's_num7' => '7日留存',
        ];
    }
}
