<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_tree".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $viplevel
 * @property integer $get_time
 * @property string $ctime
 * @property integer $status
 * @property integer $coin
 */
class LogTree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'viplevel', 'get_time', 'coin'], 'required'],
            [['gid', 'viplevel', 'get_time', 'status', 'coin'], 'integer'],
            [['ctime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => 'Gid',
            'viplevel' => 'Viplevel',
            'get_time' => 'Get Time',
            'ctime' => 'Ctime',
            'status' => 'Status',
            'coin' => 'Coin',
        ];
    }
}
