<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_max_sslchange".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $coin
 * @property integer $totalwin
 * @property integer $totalbet
 * @property integer $totalchange
 * @property string $ctime
 * @property integer $play_time
 */
class LogMaxSslchange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_max_sslchange';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'coin', 'totalwin', 'totalbet', 'totalchange', 'play_time'], 'integer'],
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
            'totalwin' => 'Totalwin',
            'totalbet' => 'Totalbet',
            'totalchange' => 'Totalchange',
            'ctime' => 'Ctime',
            'play_time' => 'Play Time',
        ];
    }
}
