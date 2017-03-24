<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_betconfig".
 *
 * @property integer $id
 * @property integer $min_num
 * @property integer $max_num
 * @property integer $ntime
 * @property integer $num_yu
 * @property integer $num_coin
 * @property integer $bidnow
 */
class CfgBetconfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_betconfig';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_num', 'max_num', 'ntime', 'num_yu', 'num_coin', 'bidnow'], 'required'],
            [['min_num', 'max_num', 'ntime', 'num_yu', 'num_coin', 'bidnow'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'min_num' => 'Min Num',
            'max_num' => 'Max Num',
            'ntime' => 'Ntime',
            'num_yu' => 'Num Yu',
            'num_coin' => 'Num Coin',
            'bidnow' => 'Bidnow',
        ];
    }
}
