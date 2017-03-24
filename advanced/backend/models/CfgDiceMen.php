<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_dice_men".
 *
 * @property integer $id
 * @property string $dicename
 */
class CfgDiceMen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_dice_men';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dicename'], 'required'],
            [['dicename'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dicename' => 'Dicename',
        ];
    }
}
