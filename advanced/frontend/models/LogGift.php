<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_gift".
 *
 * @property integer $id
 * @property integer $from_uid
 * @property integer $to_uid
 * @property integer $gift_id
 * @property string $ctime
 */
class LogGift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_gift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_uid', 'to_uid', 'gift_id', 'ctime'], 'required'],
            [['from_uid', 'to_uid', 'gift_id'], 'integer'],
            [['ctime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_uid' => 'From Uid',
            'to_uid' => 'To Uid',
            'gift_id' => 'Gift ID',
            'ctime' => 'Ctime',
        ];
    }
}
