<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "smsrecharge".
 *
 * @property string $tdate
 * @property integer $uid
 * @property double $total
 */
class Smsrecharge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smsrecharge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid'], 'integer'],
            [['total'], 'number'],
            [['tdate'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tdate' => 'Tdate',
            'uid' => 'Uid',
            'total' => 'Total',
        ];
    }
}
