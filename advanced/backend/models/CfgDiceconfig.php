<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_diceconfig".
 *
 * @property integer $id
 * @property integer $min_coin
 * @property integer $max_coin
 * @property integer $ntime
 * @property integer $didnow
 */
class CfgDiceconfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_diceconfig';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_coin', 'max_coin', 'ntime', 'didnow'], 'required'],
            [['min_coin', 'max_coin', 'ntime', 'didnow'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'min_coin' => 'Min Coin',
            'max_coin' => 'Max Coin',
            'ntime' => 'Ntime',
            'didnow' => 'Didnow',
        ];
    }
}
