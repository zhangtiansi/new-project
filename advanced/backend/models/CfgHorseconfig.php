<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_horseconfig".
 *
 * @property integer $id
 * @property integer $hid
 * @property integer $prize1
 * @property integer $prize2
 * @property integer $maxcoin
 * @property integer $dan
 */
class CfgHorseconfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_horseconfig';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hid', 'prize1', 'prize2', 'maxcoin'], 'required'],
            [['hid', 'prize1', 'prize2', 'maxcoin', 'dan'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hid' => 'Hid',
            'prize1' => 'Prize1',
            'prize2' => 'Prize2',
            'maxcoin' => 'Maxcoin',
            'dan' => 'Dan',
        ];
    }
}
