<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_coin_records".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $from_uid
 * @property integer $change_type
 * @property integer $change_before
 * @property integer $change
 * @property integer $change_after
 * @property string $game_no
 * @property integer $prop_id
 * @property string $ctime
 */
class LogCoinRecords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_coin_records';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'change_type', 'change_before', 'change', 'change_after', 'ctime'], 'required'],
            [['uid', 'from_uid', 'change_type', 'change_before', 'change', 'change_after', 'prop_id'], 'integer'],
            [['ctime'], 'safe'],
            [['game_no'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'from_uid' => 'From Uid',
            'change_type' => 'Change Type',
            'change_before' => 'Change Before',
            'change' => 'Change',
            'change_after' => 'Change After',
            'game_no' => 'Game No',
            'prop_id' => 'Prop ID',
            'ctime' => 'Ctime',
        ];
    }
}
