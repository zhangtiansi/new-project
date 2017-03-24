<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_daily_stay".
 *
 * @property integer $id
 * @property string $udate
 * @property string $channel
 * @property integer $stay2
 * @property integer $activestay2
 * @property integer $paystay2
 * @property integer $stay3
 * @property integer $activestay3
 * @property integer $paystay3
 * @property integer $stay7
 * @property integer $activestay7
 * @property integer $paystay7
 * @property integer $regtotal
 */
class DataDailyStay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_daily_stay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['udate', 'channel', 'stay2', 'activestay2', 'paystay2', 'stay3', 'activestay3', 'paystay3', 'stay7', 'activestay7', 'paystay7', 'regtotal'], 'required'],
            [['udate'], 'safe'],
            [['stay2', 'activestay2', 'paystay2', 'stay3', 'activestay3', 'paystay3', 'stay7', 'activestay7', 'paystay7', 'regtotal'], 'integer'],
            [['channel'], 'string', 'max' => 22]
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
            'stay2' => '次日登录留存',
            'activestay2' => '次日活跃留存',
            'paystay2' => '次日付费留存',
            'stay3' => '3日登录留存',
            'activestay3' => '3日活跃留存',
            'paystay3' => '3日付费留存',
            'stay7' => '7日登录留存',
            'activestay7' => '7日活跃留存',
            'paystay7' => '7日付费留存',
            'regtotal' => '当日总注册人数',
        ];
    }
    public static function getPercentText($d,$m)
    {
        return '人数:'.$d."比例:".Yii::$app->formatter->asPercent($d/$m,2);
    }
}
