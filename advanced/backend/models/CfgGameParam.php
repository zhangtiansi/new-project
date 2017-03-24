<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_game_param".
 *
 * @property integer $id
 * @property string $param_key
 * @property string $param_value
 * @property string $utime
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
            [['param_key', 'param_value', 'utime'], 'required'],
            [['utime'], 'safe'],
            [['param_key'], 'string', 'max' => 20],
            [['param_value'], 'string', 'max' => 30],
            [['param_key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'param_key' => 'Param Key',
            'param_value' => 'Param Value',
            'utime' => 'Utime',
        ];
    }
    public static function getOnline()
    {
        return CfgGameParam::findOne(['param_key'=>'SYS_ONLINE'])->param_value;
    }
    public static function ReloadParam()
    {
        if(CfgGameParam::updateAll(['param_value'=>'0'],['param_key'=>'SYS_RELOAD']))
            return true;
        else 
            return false;
    }
    
}
