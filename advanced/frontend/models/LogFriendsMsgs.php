<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_friends_msgs".
 *
 * @property integer $id
 * @property integer $from_uid
 * @property integer $to_uid
 * @property integer $type
 * @property integer $status
 * @property string $msg_content
 * @property string $ctime
 */
class LogFriendsMsgs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_friends_msgs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_uid', 'to_uid', 'type', 'status', 'msg_content', 'ctime'], 'required'],
            [['from_uid', 'to_uid', 'type', 'status'], 'integer'],
            [['ctime'], 'safe'],
            [['msg_content'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_uid' => 'From Uid',
            'to_uid' => 'To Uid',
            'type' => 'Type',
            'status' => 'Status',
            'msg_content' => 'Msg Content',
            'ctime' => 'Ctime',
        ];
    }
}
