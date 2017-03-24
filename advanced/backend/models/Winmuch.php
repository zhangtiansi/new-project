<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "winmuch".
 *
 * @property integer $gid
 * @property string $name
 * @property integer $power
 * @property integer $money
 * @property integer $win
 * @property integer $lose
 * @property string $reg_channel
 * @property string $last_login
 * @property string $reg_time
 */
class Winmuch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'winmuch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'power', 'money', 'win', 'lose'], 'integer'],
            [['reg_channel', 'reg_time'], 'required'],
            [['last_login', 'reg_time'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['reg_channel'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'name' => '昵称',
            'power' => 'VIP',
            'money' => '金币',
            'win' => 'Win',
            'lose' => 'Lose',
            'reg_channel' => '注册渠道',
            'last_login' => '最后登录时间',
            'reg_time' => '注册时间',
        ];
    }
}
