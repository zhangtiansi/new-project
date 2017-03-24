<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_channel_user".
 *
 * @property integer $id
 * @property string $udate
 * @property string $channel
 * @property string $activenum
 * @property integer $regactive
 */
class DataChannelUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_channel_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['udate', 'channel'], 'required'],
            [['udate'], 'safe'],
            [['regactive'], 'integer'],
            [['channel', 'activenum'], 'string', 'max' => 55]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'udate' => '日期',
            'channel' => '渠道',
            'activenum' => 'Activenum',
            'regactive' => '注册用户',
        ];
    }
}
