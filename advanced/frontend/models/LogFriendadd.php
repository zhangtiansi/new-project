<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_friendadd".
 *
 * @property integer $id
 * @property integer $aid_from
 * @property string $from_name
 * @property integer $aid_to
 * @property string $to_name
 * @property integer $type
 * @property integer $mark
 */
class LogFriendadd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_friendadd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid_from', 'from_name', 'aid_to', 'to_name', 'type', 'mark'], 'required'],
            [['aid_from', 'aid_to', 'type', 'mark'], 'integer'],
            [['from_name', 'to_name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aid_from' => 'Aid From',
            'from_name' => 'From Name',
            'aid_to' => 'Aid To',
            'to_name' => 'To Name',
            'type' => 'Type',
            'mark' => 'Mark',
        ];
    }
}
