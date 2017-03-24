<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_tree".
 *
 * @property integer $tree_id
 * @property integer $vip_level
 * @property integer $speed
 * @property integer $max_coin
 */
class CfgTree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_level', 'speed', 'max_coin'], 'required'],
            [['vip_level', 'speed', 'max_coin'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tree_id' => 'Tree ID',
            'vip_level' => 'Vip Level',
            'speed' => 'Speed',
            'max_coin' => 'Max Coin',
        ];
    }
}
