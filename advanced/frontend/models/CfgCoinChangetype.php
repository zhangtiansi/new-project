<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_coin_changetype".
 *
 * @property integer $cid
 * @property string $c_name
 * @property string $c_desc
 * @property string $ctime
 */
class CfgCoinChangetype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_coin_changetype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['c_name', 'c_desc', 'ctime'], 'required'],
            [['ctime'], 'safe'],
            [['c_name'], 'string', 'max' => 20],
            [['c_desc'], 'string', 'max' => 50],
            [['c_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'c_name' => 'C Name',
            'c_desc' => 'C Desc',
            'ctime' => 'Ctime',
        ];
    }
}
