<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_war_banker".
 *
 * @property integer $id
 * @property integer $men_1
 * @property integer $men_2
 * @property integer $men_3
 * @property integer $men_4
 * @property integer $men_5
 * @property integer $b_open
 */
class CfgWarBanker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_war_banker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'men_1', 'men_2', 'men_3', 'men_4', 'men_5', 'b_open'], 'required'],
            [['id', 'men_1', 'men_2', 'men_3', 'men_4', 'men_5', 'b_open'], 'integer'],
            [['id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'men_1' => '通杀',
            'men_2' => '杀三门',
            'men_3' => '杀两门',
            'men_4' => '杀一门',
            'men_5' => '通赔',
            'b_open' => '是否开启',
        ];
    }
    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        CfgGameParam::ReloadParam();
    }
}
