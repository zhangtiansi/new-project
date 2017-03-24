<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_game_cmd".
 *
 * @property integer $id
 * @property integer $cmd
 * @property integer $mark
 * @property integer $state
 * @property string $str_desc
 * @property integer $to_id
 */
class CfgGameCmd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_game_cmd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cmd', 'mark', 'state', 'str_desc', 'to_id'], 'required'],
            [['cmd', 'mark', 'state', 'to_id'], 'integer'],
            [['str_desc'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cmd' => 'Cmd',
            'mark' => 'Mark',
            'state' => 'State',
            'str_desc' => 'Str Desc',
            'to_id' => 'To ID',
        ];
    }
}
