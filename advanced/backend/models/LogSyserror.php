<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_Syserror".
 *
 * @property integer $id
 * @property string $keyword
 * @property string $contents
 * @property string $loglevel
 * @property string $ctime
 */
class LogSyserror extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_Syserror';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keyword', 'contents'], 'required'],
            [['ctime'], 'safe'],
            [['keyword', 'loglevel'], 'string', 'max' => 30],
            [['contents'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'keyword' => 'Keyword',
            'contents' => 'Contents',
            'loglevel' => 'Loglevel',
            'ctime' => 'Ctime',
        ];
    }
}
