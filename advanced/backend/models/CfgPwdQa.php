<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_pwd_qa".
 *
 * @property integer $qid
 * @property string $q_content
 * @property string $ctime
 */
class CfgPwdQa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_pwd_qa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q_content', 'ctime'], 'required'],
            [['ctime'], 'safe'],
            [['q_content'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qid' => 'Qid',
            'q_content' => 'Q Content',
            'ctime' => 'Ctime',
        ];
    }
}
