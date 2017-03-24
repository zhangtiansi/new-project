<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sys_oplogs".
 *
 * @property integer $id
 * @property integer $opid
 * @property string $keyword
 * @property integer $cid
 * @property integer $gid
 * @property string $logs
 * @property string $desc
 * @property string $ctime
 */
class SysOplogs extends \yii\db\ActiveRecord
{
    public static $KEYWORD_SSL_OPS="sslp4";
    public static $KEYWORD_SSL_CARD="sslpc";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_oplogs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['opid', 'keyword',  'ctime'], 'required'],
            [['opid', 'cid', 'gid'], 'integer'],
            [['ctime'], 'safe'],
            [['keyword'], 'string', 'max' => 20],
            [['logs'], 'string', 'max' => 300],
            [['desc'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'opid' => '操作员',
            'keyword' => '关键字',
            'cid' => '赠送id',
            'gid' => '用户id',
            'logs' => '日志',
            'desc' => '描述',
            'ctime' => '时间',
        ];
    }
}
