<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_wechat_info".
 *
 * @property integer $id
 * @property string $openid
 * @property string $nickname
 * @property string $province
 * @property string $city
 * @property string $country
 * @property string $headimgurl
 * @property string $privilege
 * @property string $ctime
 * @property integer $gid
 */
class GmWechatInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_wechat_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid', 'nickname', 'province', 'city', 'country',], 'required'],
            [['headimgurl', 'privilege'], 'string'],
            [['ctime'], 'safe'],
            [['gid'], 'integer'],
            [['openid'], 'string', 'max' => 80],
            [['nickname'], 'string', 'max' => 30],
            [['province', 'city', 'country'], 'string', 'max' => 50],
            [['openid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'nickname' => 'Nickname',
            'province' => 'Province',
            'city' => 'City',
            'country' => 'Country',
            'headimgurl' => 'Headimgurl',
            'privilege' => 'Privilege',
            'ctime' => 'Ctime',
            'gid' => 'Gid',
        ];
    }
}
