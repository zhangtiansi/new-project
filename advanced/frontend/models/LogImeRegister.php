<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_ime_register".
 *
 * @property string $ime
 * @property integer $gid
 * @property string $reg_time
 * @property integer $reg_num
 * @property integer $reg_channel
 */
class LogImeRegister extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_ime_register';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ime', 'gid', 'reg_channel'], 'required'],
            [['gid', 'reg_num', 'reg_channel'], 'integer'],
            [['reg_time'], 'safe'],
            [['ime'], 'string', 'max' => 80]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ime' => 'Ime',
            'gid' => 'Gid',
            'reg_time' => 'Reg Time',
            'reg_num' => 'Reg Num',
            'reg_channel' => 'Reg Channel',
        ];
    }
}