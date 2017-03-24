<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_vip_level".
 *
 * @property integer $vip_level
 * @property integer $vip_exp
 * @property integer $vip_reward
 * @property string $ctime
 */
class CfgVipLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_vip_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_exp', 'vip_reward', 'ctime'], 'required'],
            [['vip_exp', 'vip_reward'], 'integer'],
            [['ctime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vip_level' => 'Vip Level',
            'vip_exp' => 'Vip Exp',
            'vip_reward' => 'Vip Reward',
            'ctime' => 'Ctime',
        ];
    }
}
