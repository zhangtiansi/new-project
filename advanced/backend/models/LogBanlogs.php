<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_banlogs".
 *
 * @property integer $id
 * @property integer $gid
 * @property string $ban_time
 * @property string $ban_desc
 * @property integer $ban_type
 */
class LogBanlogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_banlogs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'ban_type'], 'integer'],
            [['ban_time'], 'safe'],
            [['ban_desc'], 'string', 'max' => 255]
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
            'ban_time' => 'Ban Time',
            'ban_desc' => 'Ban Desc',
            'ban_type' => 'Ban Type',
        ];
    }
}
