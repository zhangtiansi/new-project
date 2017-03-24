<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_announcement".
 *
 * @property integer $id
 * @property string $content
 * @property string $pic
 * @property integer $status
 * @property string $ctime
 */
class GmAnnouncement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_announcement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'pic', 'status', 'ctime'], 'required'],
            [['status'], 'integer'],
            [['ctime'], 'safe'],
            [['content'], 'string', 'max' => 250],
            [['pic'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'pic' => '图片',
            'status' => '状态',
            'ctime' => 'Ctime',
        ];
    }
    
    public static function getAnnu()
    {
        $st=GmAnnouncement::findOne(['status'=>3]);
        if (is_object($st)){
            return $st->attributes;
        }else {
            return [];
        }
    }
}
