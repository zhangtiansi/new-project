<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_game_param".
 *
 * @property string $paramkey
 * @property string $paramvalue
 * @property integer $begin_time
 * @property integer $end_time
 */
class CfgGameParam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_game_param';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paramkey', 'paramvalue', 'begin_time', 'end_time'], 'required'],
            [['begin_time', 'end_time'], 'integer'],
            [['paramkey'], 'string', 'max' => 50],
            [['paramvalue'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'paramkey' => 'Paramkey',
            'paramvalue' => 'Paramvalue',
            'begin_time' => 'Begin Time',
            'end_time' => 'End Time',
        ];
    }
}
