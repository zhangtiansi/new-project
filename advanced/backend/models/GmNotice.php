<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_notice".
 *
 * @property integer $id
 * @property string $name
 * @property integer $tag
 * @property integer $type
 * @property string $title
 * @property string $content
 * @property string $content_time
 * @property string $tips
 * @property string $utime
 * @property integer $status
 */
class GmNotice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'content', 'content_time', 'status'], 'required'],
            [['tag', 'type', 'status'], 'integer'],
            [['utime'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 100],
            [['content'], 'string', 'max' => 512],
            [['content_time', 'tips'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'tag' => 'Tag',
            'type' => 'Type',
            'title' => '标题',
            'content' => '内容',
            'content_time' => '内容时间',
            'tips' => '提示信息/落款',
            'utime' => '修改时间',
            'status' => '状态',
        ];
    }
}
