<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_ssl_new".
 *
 * @property integer $id
 * @property integer $begin_id
 * @property integer $end_id
 */
class CfgSslNew extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_ssl_new';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'begin_id', 'end_id'], 'required'],
            [['id', 'begin_id', 'end_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'begin_id' => 'Begin ID',
            'end_id' => 'End ID',
        ];
    }
}
