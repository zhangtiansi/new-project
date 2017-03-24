<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "cfg_props".
 *
 * @property integer $id
 * @property string $prop_name
 * @property integer $prop_cost
 * @property integer $cost_type
 * @property string $utime
 * @property integer $prop_type
 * @property integer $charm
 * @property integer $change
 */
class CfgProps extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_props';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prop_name', 'prop_cost', 'utime', 'charm', 'change'], 'required'],
            [['prop_cost', 'cost_type', 'prop_type', 'charm', 'change'], 'integer'],
            [['utime'], 'safe'],
            [['prop_name'], 'string', 'max' => 20],
            [['prop_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prop_name' => 'Prop Name',
            'prop_cost' => 'Prop Cost',
            'cost_type' => 'Cost Type',
            'utime' => 'Utime',
            'prop_type' => 'Prop Type',
            'charm' => 'Charm',
            'change' => 'Change',
        ];
    }
    
    public static function getgiftPropList(){
        $ar = CfgProps::findAll([7,8,9,21]);
        return $ar;   
    }
    
    public static function getNameByid($pid)
    {
        return CfgProps::findOne($pid)->prop_name;
        
    }
    
    public static function getGiftList(){
        $ar = CfgProps::findAll([1,2,3,4,6,11]);
        return $ar;   
    }
}
