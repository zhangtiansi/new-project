<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_max_gamechange".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $coin
 * @property integer $totalchange
 * @property string $ctime
 * @property integer $play_time
 */
class LogMaxGamechange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_max_gamechange';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'coin', 'totalchange', 'play_time'], 'integer'],
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
            'coin' => 'Coin',
            'totalchange' => 'Totalchange',
            'ctime' => 'Ctime',
            'play_time' => 'Play Time',
        ];
    }
}
