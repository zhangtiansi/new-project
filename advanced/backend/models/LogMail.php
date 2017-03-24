<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_mail".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $from_id
 * @property string $title
 * @property string $content
 * @property string $ctime
 * @property integer $status
 */
class LogMail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_mail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'title', 'content', 'ctime', 'status'], 'required'],
            [['gid', 'from_id', 'status'], 'integer'],
            [['content'], 'string'],
            [['ctime'], 'safe'],
            [['title'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => '收件人UID',
            'from_id' => '发件人UID',
            'title' => '标题',
            'content' => '内容',
            'ctime' => '创建时间',
            'status' => '状态',
        ];
    }
}
