<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_blacklist".
 *
 * @property integer $id
 * @property string $ime
 * @property integer $status
 * @property string $ctime
 */
class LogBlacklist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_blacklist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ime', 'status'], 'required'],
            [['status'], 'integer'],
            [['ctime'], 'safe'],
            [['ime'], 'string', 'max' => 60],
            [['ime'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ime' => 'Ime',
            'status' => '状态',
            'ctime' => '修改时间',
        ];
    }
}
