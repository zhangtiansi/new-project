<?php

namespace app\models;

use Yii;
use app\components\ApiErrorCode;

/**
 * This is the model class for table "log_tree".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $viplevel
 * @property integer $get_time
 * @property string $ctime
 * @property integer $status
 * @property integer $coin
 */
class LogTree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'viplevel', 'get_time', 'coin'], 'required'],
            [['gid', 'viplevel', 'get_time', 'status', 'coin'], 'integer'],
            [['ctime'], 'safe']
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
            'viplevel' => 'Viplevel',
            'get_time' => 'Get Time',
            'ctime' => 'Ctime',
            'status' => 'Status',
            'coin' => 'Coin',
        ];
    }
    
    public static function getTreeCoin($gid)
    {
        //玩家vip等级
        $user = GmPlayerInfo::findOne(['account_id'=>$gid]);
        $viplevel=$user->power;
        $treecfg = CfgTree::findOne(['vip_level'=>$viplevel]);
        $limit = $treecfg->max_coin;
        $speed = $treecfg->speed;
        //运营活动
        $act = GmOptact::findOne(5);
        if (is_object($act)){
            if ($act->begin_tm<date('Y-m-d H:i:s') && $act->end_tm>date('Y-m-d H:i:s'))
            {//在活动周期里
                $limit=$limit*2;
                $speed=$speed*2;
            }
        }
        
        $count = LogTree::find()->where(['gid'=>$gid])->count();
        //今天凌晨0点
        $tdtime = strtotime(date('Y-m-d 00:00:00'));
        //现在时间
        $curtime = time();
        if ($count==0)
        {//没领过
            $time = $curtime-$tdtime;//当前至凌晨起秒数
            $tt = $time<3600*2?0:floor($time/3600/2);//计算有几个2小时
            $coin = $tt*$speed;//可领金币
            $coin=($coin>$limit)?$limit:$coin;//不能溢出
            $nexttime = 3600*2-($time-$tt*2*3600);//下次可领秒数
            Yii::error("gid".$gid." tt: ".$tt." coin :".$coin." time:  ".$time." nexttime :".$nexttime." floor :".floor($time/3600/2));
        }else {//有记录
            $lastlog = LogTree::find()->where(['gid'=>$gid])
                            ->orderBy(['ctime'=>SORT_DESC])
                            ->limit(1)->one();
            $lasttime=$lastlog->get_time;//上次领取时间,只记录整2小时的unix时间戳
            //得到当前整2小时
            $time = $curtime-$tdtime;//当前至凌晨起秒数
            $tt = $time<3600*2?0:floor($time/3600/2);//计算有几个2小时
            $bftime=$tdtime+3600*2*$tt;//获取上一个2小时
            $nexttime = 3600*2-($time-$tt*2*3600);//下次可领秒数
            $tx = floor(($bftime-$lasttime)/3600/2);//获取空闲时间
            $coin=$tx*$speed;
            $coin=($coin>$limit)?$limit:$coin;//不能溢出
            Yii::error("gid".$gid."tt: ".$tt." tx:".$tx." coin ".$coin." nex :".$nexttime);
        }
        $res = ApiErrorCode::$OK;
        $res['info']=[
            'coin'=>$coin,//可领金币
            'nexttime'=>$nexttime,//下一次领取剩余时间（秒）
            'speed'=>$speed,//增长速度（金币/2小时）
            'maxcoin'=>$limit,//溢出容量
        ];
        return $res;
    }
    
    public static function doTreeCoin($gid)
    {
        //玩家vip等级
        $user = GmPlayerInfo::findOne(['account_id'=>$gid]);
        $viplevel=$user->power;
        $treecfg = CfgTree::findOne(['vip_level'=>$viplevel]);
        $limit = $treecfg->max_coin;
        $speed = $treecfg->speed;
        //运营活动
        $act = GmOptact::findOne(5);
        if (is_object($act)){
            if ($act->begin_tm<date('Y-m-d H:i:s') && $act->end_tm>date('Y-m-d H:i:s'))
            {//在活动周期里
                $limit=$limit*2;
                $speed=$speed*2;
            }
        }
        $count = LogTree::find()->where(['gid'=>$gid])->count();
        //今天凌晨0点
        $tdtime = strtotime(date('Y-m-d 00:00:00'));
        //现在时间
        $curtime = time();
        if ($count==0)
        {//没领过
            $time = $curtime-$tdtime;//当前至凌晨起秒数
            $tt = $time<3600*2?0:floor($time/3600/2);//计算有几个2小时
            $bftime=$tdtime+3600*2*$tt;//获取上一个2小时
            $coin = $tt*$speed;//可领金币
            $coin=($coin>$limit)?$limit:$coin;//不能溢出
            $nexttime = 3600*2-($time-$tt*2*3600);//下次可领秒数
            Yii::error("gid".$gid." tt: ".$tt." coin :".$coin." time:  ".$time." nexttime :".$nexttime." floor :".floor($time/3600/2));
        }else {//有记录
            $lastlog = LogTree::find()->where(['gid'=>$gid])
                            ->orderBy(['ctime'=>SORT_DESC])
                            ->limit(1)->one();
            $lasttime=$lastlog->get_time;//上次领取时间,只记录整2小时的unix时间戳
            //得到当前整2小时
            $time = $curtime-$tdtime;//当前至凌晨起秒数
            $tt = $time<3600*2?0:floor($time/3600/2);//计算有几个2小时
            $bftime=$tdtime+3600*2*$tt;//获取上一个2小时
            $nexttime = 3600*2-($time-$tt*2*3600);//下次可领秒数
            $tx = floor(($bftime-$lasttime)/3600/2);//获取空闲时间
            $coin=$tx*$speed;
            $coin=($coin>$limit)?$limit:$coin;//不能溢出
            Yii::error("gid".$gid."tt: ".$tt." tx:".$tx." coin ".$coin." nex :".$nexttime);
        }
        //'gid' => 'Gid',
//             'viplevel' => 'Viplevel',
//             'get_time' => 'Get Time',
//             'ctime' => 'Ctime',
//             'status' => 'Status',
//             'coin' => 'Coin',
        if ($coin==0){
            $res = ApiErrorCode::$OK;
            $res['info']=[
                'coin'=>$coin,//可领金币
                'nexttime'=>$nexttime,//下一次领取剩余时间（秒）
                'speed'=>$speed,//增长速度（金币/2小时）
                'maxcoin'=>$limit,//溢出容量
            ];
            return $res;
        }
        $newRecord = new LogTree();
        $newRecord->gid = $gid;
        $newRecord->viplevel = $viplevel;
        $newRecord->get_time = $bftime;
        $newRecord->status = 1;
        $newRecord->coin = $coin;
        $actlog = new LogActrewards();
        $actlog->gid=$gid;
        $actlog->coin=$coin;
        $actlog->status=1;
        $actlog->change_type=strval(19);//变更类型为摇钱树
        if ($newRecord->save()&& $actlog->save()){
            $res = ApiErrorCode::$OK;
            $res['info']=[
                'coin'=>0,//可领金币
                'nexttime'=>$nexttime,//下一次领取剩余时间（秒）
                'speed'=>$speed,//增长速度（金币/2小时）
                'maxcoin'=>$limit,//溢出容量
                'getcoin'=>$coin,
            ];
        }else {
            $res=ApiErrorCode::$TreeDoFailed;
            Yii::error("gid".$gid."save tree log failed, errors:".print_r($newRecord->getErrors(),true)." actlog: ".print_r($actlog->getErrors(),true));
        }
        return $res;
    }
}
