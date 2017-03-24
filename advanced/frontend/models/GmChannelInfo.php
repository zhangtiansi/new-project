<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_channel_info".
 *
 * @property integer $cid
 * @property string $channel_name
 * @property string $channel_desc
 * @property string $opname
 * @property string $oppasswd
 * @property integer $status
 * @property string $cur_version
 * @property string $update_url
 * @property string $version_code
 * @property string $changelog
 * @property integer $force
 * @property string $ctime
 */
class GmChannelInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_channel_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_name', 'cur_version', 'version_code', 'changelog', 'force'], 'required'],
            [['status', 'force'], 'integer'],
            [['changelog'], 'string'],
            [['ctime'], 'safe'],
            [['channel_name', 'opname', 'cur_version', 'version_code'], 'string', 'max' => 20],
            [['channel_desc'], 'string', 'max' => 100],
            [['oppasswd'], 'string', 'max' => 30],
            [['update_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'channel_name' => 'Channel Name',
            'channel_desc' => 'Channel Desc',
            'opname' => 'Opname',
            'oppasswd' => 'Oppasswd',
            'status' => 'Status',
            'cur_version' => 'Cur Version',
            'update_url' => 'Update Url',
            'version_code' => 'Version Code',
            'changelog' => 'Changelog',
//             'force' => 'Force',
//             'ctime' => 'Ctime',
            'force' => 'Force',
            'ctime' => '更新时间',
            'p_user' => '用户数据配比',
            'p_recharge' => '充值数据配比',
            'p_gm'=>'局数配比(大于几局才算活跃，只在渠道后台统计)',
            'pay_method'=>'支付方式',
            'ipay'=>'爱贝编号',
            'inreviewstat'=>'iOS审核状态',
            'inreviewbuild'=>'iOS审核build', 
        ];
    }
}
