<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_userlogin".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $logintime
 * @property integer $loginouttime
 */
class LogUserlogin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_userlogin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'logintime', 'loginouttime'], 'required'],
            [['gid', 'logintime', 'loginouttime'], 'integer']
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
            'logintime' => 'Logintime',
            'loginouttime' => 'Loginouttime',
        ];
    }
}
