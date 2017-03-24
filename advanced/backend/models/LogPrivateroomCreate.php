<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_privateroom_create".
 *
 * @property integer $id
 * @property integer $aid
 * @property integer $room_id
 * @property string $pwd
 * @property integer $ntimes
 * @property string $room_name
 * @property integer $mark
 * @property string $ctime
 */
class LogPrivateroomCreate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_privateroom_create';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'room_id', 'pwd', 'ntimes', 'room_name'], 'required'],
            [['aid', 'room_id', 'ntimes', 'mark'], 'integer'],
            [['ctime'], 'safe'],
            [['pwd', 'room_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aid' => 'Aid',
            'room_id' => 'Room ID',
            'pwd' => 'Pwd',
            'ntimes' => 'Ntimes',
            'room_name' => 'Room Name',
            'mark' => 'Mark',
            'ctime' => 'Ctime',
        ];
    }
}
