<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_kill_user".
 *
 * @property integer $id
 * @property integer $aid
 * @property string $stimes
 * @property integer $mark
 * @property integer $money
 */
class LogKillUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_kill_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'mark', 'money'], 'integer'],
            [['stimes'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aid' => 'Aid',
            'stimes' => 'Stimes',
            'mark' => 'Mark',
            'money' => 'Money',
        ];
    }
}
