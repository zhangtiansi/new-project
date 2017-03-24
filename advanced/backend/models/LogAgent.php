<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_agent".
 *
 * @property integer $id
 * @property integer $agentid
 * @property integer $agentuid
 * @property string $keyword
 * @property integer $logcid
 * @property string $ctime
 */
class LogAgent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_agent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agentid', 'agentuid', 'keyword', 'logcid', 'ctime'], 'required'],
            [['agentid', 'agentuid', 'logcid'], 'integer'],
            [['ctime'], 'safe'],
            [['keyword'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agentid' => 'Agentid',
            'agentuid' => 'Agentuid',
            'keyword' => 'Keyword',
            'logcid' => 'Logcid',
            'ctime' => 'Ctime',
        ];
    }
}
