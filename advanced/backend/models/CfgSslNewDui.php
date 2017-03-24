<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_ssl_new_dui".
 *
 * @property integer $id
 * @property integer $cfg_jin
 * @property integer $cfg_shun
 * @property integer $cfg_dui
 * @property integer $cfg_san
 * @property integer $staus
 * @property string $desc
 */
class CfgSslNewDui extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_ssl_new_dui';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cfg_jin', 'cfg_shun', 'cfg_dui', 'cfg_san', 'staus', 'desc'], 'required'],
            [['id', 'cfg_jin', 'cfg_shun', 'cfg_dui', 'cfg_san', 'staus'], 'integer'],
            [['desc'], 'string', 'max' => 64],
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
            'cfg_jin' => 'Cfg Jin',
            'cfg_shun' => 'Cfg Shun',
            'cfg_dui' => 'Cfg Dui',
            'cfg_san' => 'Cfg San',
            'staus' => 'Staus',
            'desc' => 'Desc',
        ];
    }
}
