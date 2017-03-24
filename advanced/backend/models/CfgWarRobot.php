<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_war_robot".
 *
 * @property integer $id
 * @property string $r_name
 * @property integer $r_vip
 * @property integer $r_coin
 */
class CfgWarRobot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_war_robot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['r_vip', 'r_coin'], 'integer'],
            [['r_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'r_name' => 'R Name',
            'r_vip' => 'R Vip',
            'r_coin' => 'R Coin',
        ];
    }
}
