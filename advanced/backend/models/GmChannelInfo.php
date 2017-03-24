<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
            [['channel_name',], 'required'],
            [['status', 'force','p_gm'], 'integer'],
            [['ctime','update_url','p_user','p_recharge','pay_method','ipay','inreviewstat','inreviewbuild'], 'safe'],
            [['channel_name', 'any_channel', 'opname', 'cur_version', 'version_code'], 'string', 'max' => 20],
            [['channel_desc','changelog'], 'string', 'max' => 100],
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
            'cid' => '渠道id',
            'channel_name' => '渠道名称',
            'channel_desc' => '渠道描述',
            'any_channel'=>'anysdk渠道号',
            'opname' => '后台帐号',
            'oppasswd' => 'Oppasswd',
            'status' => 'Status',
            'cur_version' => '当前版本',
            'update_url' => 'apk地址',
            'version_code' => 'VersionCode',
            'changelog'=>'更新日志',
            'force' => '是否强更',
            'ctime' => '更新时间',
            'p_user' => '用户数据配比',
            'p_recharge' => '充值数据配比',
            'p_gm'=>'局数配比(大于几局才算活跃，只在渠道后台统计)',
            'pay_method'=>'支付方式'  ,
            'ipay'=>'爱贝编号',
            'inreviewstat'=>'iOS审核状态',
            'inreviewbuild'=>'iOS审核build', 
        ];
    }
    
    public static function findChannelNamebyid($cid)
    {
        return is_object(GmChannelInfo::findOne($cid))?GmChannelInfo::findOne($cid)->channel_name:$cid;
    }
    
    public static function findChannelidByName($channel)
    {
        return is_object(GmChannelInfo::findOne(['channel_name'=>$channel]))?GmChannelInfo::findOne(['channel_name'=>$channel])->cid:$channel;
    }
    
    public static function getChannelList(){
        $ar = GmChannelInfo::findAll([1=>1]);
        return $ar;
    }
    
    public static function getChannelDropList(){
        $ar = GmChannelInfo::find()->where('cid>1')->all();
        $ardp = array_merge([0=>"不限"],ArrayHelper::map($ar, 'cid', 'channel_name'));
        return $ardp;
    }
    
    public static function findChannelNamebyUser($userid)
    {
        
        
    }
    public function getAccount()
    {//一对一
        return $this->hasOne(User::className(), ['id' => 'opname']);
    }
    
    public function getIapparam()
    {//一对一
        return $this->hasOne(CfgIpayParams::className(), ['id' => 'ipay']);
    }
}
