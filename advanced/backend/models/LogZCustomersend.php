<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_z_customersend".
 *
 * @property integer $id
 * @property integer $opid
 * @property string $opname
 * @property string $act
 * @property integer $gid
 * @property string $desc
 * @property string $ctime
 */
class LogZCustomersend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_z_customersend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'opid', 'opname'], 'required'],
            [['id', 'opid', 'gid'], 'integer'],
            [['ctime'], 'safe'],
            [['opname', 'desc'], 'string', 'max' => 50],
            [['act'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'opid' => 'Opid',
            'opname' => 'Opname',
            'act' => 'Act',
            'gid' => 'Gid',
            'desc' => 'Desc',
            'ctime' => 'Ctime',
        ];
    }
}
