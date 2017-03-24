<?php
namespace app\components;
use yii;
use yii\helpers\Html;
use app\models\LogMail;
use yii\db\Exception;
use app\models\LogActrewards;
use app\models\LogActivities;
class Acts{
    const RechargeMan = 2;//充值满送
    const RechargeManIOS = 3;//ios 满送活动
    const LoginDailyIos = 4;//每日登录即送活动
    const VipGift = 8;//vip送礼
    const SSLRANK = 5;//时时乐排名
    const RechargeSingleDaily = 6;//每日充值单笔6元礼包
    const SpecialCardType = 7;//特殊牌型
    const RechargeFirstPrice = 9;//首充指定金额
    const RechargePriceAll = 10;//充值指定金额必送
    const SlotTimes = 11;//水浒传指定次数
    const WarWinner =12;// 百人赢四门
    const GMPlayNum =13;// 普通游戏场满N场送N万9点
    const SSLBetCoin =14;// 时时乐累积押注超过N万次日送N万10点
    const RechargeManTomorrow =15;// 首日充值满N元次日送N万金币9.30
    const WARBETTOPS =16;//百人押注排行榜
    const WARBANKERTOPS =17;//百人坐庄排行榜
    const WARWINTOPS =18;//百人盈利排行榜
    public static $actlists=[
        1=>'不可选',
        2=>'充值满送',
        3=>'ios满送活动',
        4=>'每日登录即送活动',
        5=>'时时乐排名',
        6=>'每日充值单笔6元礼包',
        7=>'特殊牌型',
        8=>'vip送礼',
        9=>'首充指定金额',
        10=>'充值指定金额必送',
        11=>'水浒传指定次数',
        12=>'百人赢四门',
        13=>'普通游戏场满N场送N万9点',
        14=>'时时乐累积押注超过N万次日送N万10点',
        15=>'首日充值满N元次日送N万金币9.30',
        16=>'百人押注排行榜9.30',
        17=>'百人坐庄排行榜9.30',
        18=>'百人盈利排行榜9.30',
    ];
    
    
    
    public static function actMan()
    {//满送活动
    $db = Yii::$app->db;
    $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
from gm_optact where status=0 and act_type='.Acts::RechargeMan.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
    $res = $db->createCommand($sql)->queryAll();
    if (count($res)>0){
        //活动列表不为空
        foreach ($res as $singleO){//每个活动
            if($singleO['standard']>0){
                $sql2 = 'select uid from
                    (SELECT `playerid` as uid, sum(fee) as total
                    FROM  `gm_orderlist`
                    where
                    `utime` BETWEEN :bgtm and :endtm
                    and `status` =2
                    and `source`!="Sms"
                    GROUP BY `playerid` HAVING total >= :standard) as ta
                    where uid not in (select uid from log_activities where actid=:actid)';
                $resgids = $db->createCommand($sql2)
                ->bindValues([':bgtm'=>$singleO['begin_tm'],':endtm'=>$singleO['end_tm'],':standard'=>$singleO['standard'],':actid'=>$singleO['id']])
                ->queryAll();
                if (count($resgids)>0){
                    foreach ($resgids as $gids){
                        //                            var_dump($gids);
                        //                            return false;
                        $gid = $gids['uid'];
                        $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                               values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                               ';
                        $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                        $maillog = new LogMail();
                        $maillog->gid=$gid;
                        $maillog->from_id=0;
                        $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                        $maillog->content=$maillog->title." 获得 ";
                        foreach ($singleO as $k=>$v)
                        {
                            if ($v!=0){
                                if ($k=="diamond"){
                                    $maillog->content.=$v."钻石";
                                }elseif ($k=="coin"){
                                    $maillog->content.=$v."金币";
                                }elseif ($k=="vcard_g"){
                                    $maillog->content.=$v."VIP金卡";
                                }elseif ($k=="vcard_s"){
                                    $maillog->content.=$v."VIP银卡";
                                }elseif ($k=="vcard_c"){
                                    $maillog->content.=$v."VIP铜卡";
                                }
                            }
                        }
                        $maillog->content.=" 系统已经自动发放到您的账户中。";
                        $maillog->ctime=date('Y-m-d H:i:s');
                        $maillog->status=0;
                        $transaction = $db->beginTransaction();
                        try {
                            $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                            $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                            $maillog->save();
                            // ... 执行其他 SQL 语句 ...
                            $transaction->commit();
                            echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                        } catch(Exception $e) {
                            Yii::info("act trans failed now rollback".print_r($e,true));
                            $transaction->rollBack();
                            echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                        }
                    }
                }else {
                    Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                    echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
                }
                echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
            }else {
                echo "standard is 0";
            }
        }
        return true;
    }else {
        Yii::info("noact valid");
        echo "no act avalible~~! <br>";
        return false;
    }
    }
    
    public static function actManIos()
    {//满送活动IOS专享
    $db = Yii::$app->db;
    $sql =  'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
    from gm_optact where status=0 and act_type='.Acts::RechargeManIOS.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
    and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
    $res = $db->createCommand($sql)->queryAll();
    if (count($res)>0){
        //活动列表不为空
        foreach ($res as $singleO){//每个活动
            if($singleO['standard']>0){
                $sql2 = 'select uid from
                        (SELECT `playerid` as uid, sum(fee) as total
                        FROM  `gm_orderlist`
                        where
                        `utime` BETWEEN :bgtm and :endtm
                        and `status` =2
                        and `source` like "appstore%"
                        GROUP BY `playerid` HAVING total >= :standard) as ta
                        where uid not in (select uid from log_activities where actid=:actid)';
                $resgids = $db->createCommand($sql2)
                ->bindValues([':bgtm'=>$singleO['begin_tm'],':endtm'=>$singleO['end_tm'],':standard'=>$singleO['standard'],':actid'=>$singleO['id']])
                ->queryAll();
                if (count($resgids)>0){
                    foreach ($resgids as $gids){
                        //                            var_dump($gids);
                        //                            return false;
                        $gid = $gids['uid'];
                        $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                   values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                   ';
                        $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                        $maillog = new LogMail();
                        $maillog->gid=$gid;
                        $maillog->from_id=0;
                        $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                        $maillog->content=$maillog->title." 获得 ";
                        foreach ($singleO as $k=>$v)
                        {
                            if ($v!=0){
                                if ($k=="diamond"){
                                    $maillog->content.=$v."钻石";
                                }elseif ($k=="coin"){
                                    $maillog->content.=$v."金币";
                                }elseif ($k=="vcard_g"){
                                    $maillog->content.=$v."VIP金卡";
                                }elseif ($k=="vcard_s"){
                                    $maillog->content.=$v."VIP银卡";
                                }elseif ($k=="vcard_c"){
                                    $maillog->content.=$v."VIP铜卡";
                                }
                            }
                        }
                        $maillog->content.=" 系统已经自动发放到您的账户中。";
                        $maillog->ctime=date('Y-m-d H:i:s');
                        $maillog->status=0;
                        $transaction = $db->beginTransaction();
                        try {
                            $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                            $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                            $maillog->save();
                            // ... 执行其他 SQL 语句 ...
                            $transaction->commit();
                            echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                        } catch(Exception $e) {
                            Yii::info("act trans failed now rollback".print_r($e,true));
                            $transaction->rollBack();
                            echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                        }
                    }
                }else {
                    Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                    echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
                }
                echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
            }else {
                echo "standard is 0";
            }
        }
        return true;
    }else {
        Yii::info("noact valid");
        echo "no act avalible~~! <br>";
        return false;
    }
    }
    
    public static function actLoginIos()
    {//每日登录即送活动
    $db = Yii::$app->db;
    $sql =  'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
        from gm_optact where status=0 and act_type='.Acts::LoginDailyIos.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
        and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s" )';
    $res = $db->createCommand($sql)->queryAll();
    if (count($res)>0){
        //活动列表不为空
        foreach ($res as $singleO){//每个活动
            $sql2 = 'select distinct(gid) as gid from `zjh`.`log_userrequst` WHERE `channel` LIKE "100%"
                        and gid not in
                        (select uid from log_activities where actid=:actid
                        and ctime between date_format(Now(),"%Y-%m-%d 00:00:00") and date_format(Now(),"%Y-%m-%d 23:59:59"))
                        and ctime > date_format(date_sub(Now(),interval 20 MINUTE),"%Y-%m-%d %H:%i:%s")
                        ';
            $resgids = $db->createCommand($sql2)
            ->bindValues([':actid'=>$singleO['id']])
            ->queryAll();
            if (count($resgids)>0){
                foreach ($resgids as $gids){
                    $gid = $gids['gid'];
                    $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                       values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                       ';
                    $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                    $maillog = new LogMail();
                    $maillog->gid=$gid;
                    $maillog->from_id=0;
                    $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                    $maillog->content=$maillog->title." 获得 ";
                    foreach ($singleO as $k=>$v)
                    {
                        if ($v!=0){
                            if ($k=="diamond"){
                                $maillog->content.=$v."钻石";
                            }elseif ($k=="coin"){
                                $maillog->content.=$v."金币";
                            }elseif ($k=="vcard_g"){
                                $maillog->content.=$v."VIP金卡";
                            }elseif ($k=="vcard_s"){
                                $maillog->content.=$v."VIP银卡";
                            }elseif ($k=="vcard_c"){
                                $maillog->content.=$v."VIP铜卡";
                            }
                        }
                    }
                    $maillog->content.=" 系统已经自动发放到您的账户中。";
                    $maillog->ctime=date('Y-m-d H:i:s');
                    $maillog->status=0;
                    $transaction = $db->beginTransaction();
                    try {
                        $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                            ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                        $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                        $maillog->save();
                        // ... 执行其他 SQL 语句 ...
                        $transaction->commit();
                        echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                    } catch(Exception $e) {
                        Yii::info("act trans failed now rollback".print_r($e,true));
                        $transaction->rollBack();
                        echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                    }
                }
            }else {
                Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
            }
            echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
        }
        return true;
    }else {
        Yii::info("noact valid");
        echo "no act avalible~~! <br>";
        return false;
    }
    }
    
    
    public static function actVipGift()
    {//
    $db = Yii::$app->db;
    $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
            from gm_optact where status=0 and act_type='.Acts::VipGift.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
            and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
    $res = $db->createCommand($sql)->queryAll();
    if (count($res)>0){
        //活动列表不为空
        foreach ($res as $singleO){//每个活动
            if ($singleO['standard']==10)//VIP10以上统一
            {
                $sql2 = 'select distinct(gid) as gid from `zjh`.`log_userrequst` t1,gm_player_info t2 WHERE
                            t1.gid=t2.account_id
                            and t2.power!=0
                            and t2.power >=10
                            and gid not in
                            (select uid from log_activities where actid=:actid
                            and ctime between date_format(Now(),"%Y-%m-%d 00:00:00") and date_format(Now(),"%Y-%m-%d 23:59:59"))
                            and ctime > date_format(date_sub(Now(),interval 20 MINUTE),"%Y-%m-%d %H:%i:%s")
                            ';
                $resgids = $db->createCommand($sql2)
                ->bindValues([':actid'=>$singleO['id']])
                ->queryAll();
            }else{
                $sql2 = 'select distinct(gid) as gid from `zjh`.`log_userrequst` t1,gm_player_info t2 WHERE
                                t1.gid=t2.account_id
                                and t2.power!=0
                                and t2.power =:viplevel
                                and gid not in
                                (select uid from log_activities where actid=:actid
                                and ctime between date_format(Now(),"%Y-%m-%d 00:00:00") and date_format(Now(),"%Y-%m-%d 23:59:59"))
                                and t1.ctime > date_format(date_sub(Now(),interval 20 MINUTE),"%Y-%m-%d %H:%i:%s")
                                ';
                $resgids = $db->createCommand($sql2)
                ->bindValues([':actid'=>$singleO['id'],':viplevel'=>$singleO['standard']])
                ->queryAll();
            }
            if (count($resgids)>0){
                foreach ($resgids as $gids){
                    $gid = $gids['gid'];
                    $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                           values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                           ';
                    $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                    $maillog = new LogMail();
                    $maillog->gid=$gid;
                    $maillog->from_id=0;
                    $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                    $maillog->content=$maillog->title." 获得 ";
                    foreach ($singleO as $k=>$v)
                    {
                        if ($v!=0){
                            if ($k=="diamond"){
                                $maillog->content.=$v."钻石";
                            }elseif ($k=="coin"){
                                $maillog->content.=$v."金币";
                            }elseif ($k=="vcard_g"){
                                $maillog->content.=$v."VIP金卡";
                            }elseif ($k=="vcard_s"){
                                $maillog->content.=$v."VIP银卡";
                            }elseif ($k=="vcard_c"){
                                $maillog->content.=$v."VIP铜卡";
                            }
                        }
                    }
                    $maillog->content.=" 系统已经自动发放到您的账户中。";
                    $maillog->ctime=date('Y-m-d H:i:s');
                    $maillog->status=0;
                    $transaction = $db->beginTransaction();
                    try {
                        $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                            ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                        $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                        $maillog->save();
                        // ... 执行其他 SQL 语句 ...
                        $transaction->commit();
                        echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                    } catch(Exception $e) {
                        Yii::info("act trans failed now rollback".print_r($e,true));
                        $transaction->rollBack();
                        echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                    }
                }
            }else {
                Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
            }
            echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
        }
        return true;
    }else {
        Yii::info("noact valid");
        echo "no act avalible~~! <br>";
        return false;
    }
    }
    
    public static function actSslRank()
    {//
    $db = Yii::$app->db;
    $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
                from gm_optact where status=0 and act_type='.Acts::SSLRANK.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
                and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
    $res = $db->createCommand($sql)->queryAll();
    if (count($res)>0){
        //活动列表不为空
    
        $sql2 = 'call getSslWinner(date_format(date_sub(Now(),interval 1 day),"%Y-%m-%d 00:00:00"),date_format(date_sub(Now(),interval 1 day),"%Y-%m-%d 23:59:59"));';
            $resgids = $db->createCommand($sql2)->queryAll();
            if (count($resgids)>0){//有排行
            foreach ($resgids as $K=>$gids){
            //$k 是下标
            $rank = $K+1;
                foreach ($res as $singleO){//每个排名的奖励
                if($rank<=$singleO['standard'])
                {//排名1的时候
                    $gid = $gids['gid'];
                    $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                               values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                               ';
                            $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                    $maillog = new LogMail();
                            $maillog->gid=$gid;
                        $maillog->from_id=0;
                        $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                        $maillog->content=$maillog->title." 获得 ";
                        foreach ($singleO as $k=>$v)
                        {
                        if ($v!=0){
                        if ($k=="diamond"){
                        $maillog->content.=$v."钻石";
                    }elseif ($k=="coin"){
                            $maillog->content.=$v."金币";
                            }elseif ($k=="vcard_g"){
                                $maillog->content.=$v."VIP金卡";
                            }elseif ($k=="vcard_s"){
                                $maillog->content.=$v."VIP银卡";
                                }elseif ($k=="vcard_c"){
                                $maillog->content.=$v."VIP铜卡";
                                }
                                }
                                }
                                    $maillog->content.=" 系统已经自动发放到您的账户中。";
                                        $maillog->ctime=date('Y-m-d H:i:s');
                                            $maillog->status=0;
                                                $transaction = $db->beginTransaction();
                                                try {
                                                $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                                ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                                                    $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                                                    $maillog->save();
                                                    // ... 执行其他 SQL 语句 ...
                                                    $transaction->commit();
                                                    echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                                                } catch(Exception $e) {
                                                Yii::info("act trans failed now rollback".print_r($e,true));
                                                $transaction->rollBack();
                                                echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                                                }
                                                break;
                                                }
                    }
                    }
                    }
                    else {
                    //没有排行榜
            }
            return true;
            }else {
            Yii::info("noact sslrank valid");
            echo "no act sslrank avalible~~! <br>";
                return false;
            }
    }
    
    public static function actRechargePrice()
        {//充值单笔每日送（6元礼包）
        $db = Yii::$app->db;
        $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
    from gm_optact where status=0 and act_type='.Acts::RechargeSingleDaily.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
    and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
        $res = $db->createCommand($sql)->queryAll();
        if (count($res)>0){
        //活动列表不为空
        foreach ($res as $singleO){//每个活动
        if($singleO['standard']>0){
            $sql2 = 'select uid from
            (SELECT distinct(`playerid`) as uid
            FROM  `gm_orderlist`
            where
                `utime` BETWEEN :bgtm and :endtm
                        and `status` =2
                        and `source`!="Sms"
                        and fee = :standard) as ta
                        where uid not in (select uid from log_activities where actid=:actid and ctime between date_format(Now(),"%Y-%m-%d 00:00:00") and date_format(Now(),"%Y-%m-%d 23:59:59"))';
                    $resgids = $db->createCommand($sql2)
                    ->bindValues([':bgtm'=>$singleO['begin_tm'],':endtm'=>$singleO['end_tm'],':standard'=>$singleO['standard'],':actid'=>$singleO['id']])
                ->queryAll();
                if (count($resgids)>0){
                    foreach ($resgids as $gids){
                    //                            var_dump($gids);
                        //                            return false;
                        $gid = $gids['uid'];
                            $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                ';
                            $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                            $maillog = new LogMail();
                            $maillog->gid=$gid;
                            $maillog->from_id=0;
                                $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                                    $maillog->content=$maillog->title." 获得 ";
                                    foreach ($singleO as $k=>$v)
                                    {
                                    if ($v!=0){
                                        if ($k=="diamond"){
                                        $maillog->content.=$v."钻石";
                            }elseif ($k=="coin"){
                            $maillog->content.=$v."金币";
                            }elseif ($k=="vcard_g"){
                                $maillog->content.=$v."VIP金卡";
                                }elseif ($k=="vcard_s"){
                                $maillog->content.=$v."VIP银卡";
                                }elseif ($k=="vcard_c"){
                                $maillog->content.=$v."VIP铜卡";
                                }
                                }
                                }
                                $maillog->content.=" 系统已经自动发放到您的账户中。";
                                    $maillog->ctime=date('Y-m-d H:i:s');
                                    $maillog->status=0;
                                        $transaction = $db->beginTransaction();
                                        try {
                                        $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                        ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                                            $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                                            $maillog->save();
                                                // ... 执行其他 SQL 语句 ...
                                                $transaction->commit();
                                        echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                                        } catch(Exception $e) {
                                        Yii::info("act trans failed now rollback".print_r($e,true));
                                        $transaction->rollBack();
                                            echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                                            }
                                            }
                                            }else {
                                            Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                                            echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
                                            }
                                            echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
                                            }else {
                                            echo "standard is 0";
        }
        }
        return true;
        }else {
                                            Yii::info("noact valid");
                                            echo "no act avalible~~! <br>";
                                            return false;
                                            }
    }
    
    public static function actEspecialCardType()
    {//特殊牌型奖励7
        $db = Yii::$app->db;
        $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
        from gm_optact where status=0 and act_type='.Acts::SpecialCardType.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
        and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
        $res = $db->createCommand($sql)->queryAll();
            if (count($res)>0){
            //活动列表不为空
            foreach ($res as $singleO){//每个活动
            $sql2="";
                if($singleO['standard']==14){
                //AAA牌型
                    $sql2 = 'select uid from
                        (SELECT distinct uid FROM `zjh`.`log_coin_records` where
                            card_num="14-14-14"
                            and  `ctime` > date_format(date_sub(Now(),interval 5 MINUTE),"%Y-%m-%d %H:%i:%s")
                            ) as ta
                            where uid not in (select uid from log_activities where actid=:actid  and ctime between date_format(Now(),"%Y-%m-%d 00:00:00") and date_format(Now(),"%Y-%m-%d 23:59:59"))';
                    $cardtype="14-14-14";
                    }elseif ($singleO['standard']==11){
                    $sql2 = 'select uid from
                    (SELECT distinct uid FROM `zjh`.`log_coin_records` where
                            card_num in ("11-11-11","12-12-12","13-13-13")
                            and  `ctime` > date_format(date_sub(Now(),interval 5 MINUTE),"%Y-%m-%d %H:%i:%s")
                            ) as ta
                            where uid not in (select uid from log_activities where actid=:actid  and ctime between date_format(Now(),"%Y-%m-%d 00:00:00") and date_format(Now(),"%Y-%m-%d 23:59:59"))';
                }elseif ($singleO['standard']==7){
                        $sql2 = 'select uid from
                        (SELECT distinct uid FROM `zjh`.`log_coin_records` where
                            card_num in ("10-10-10","9-9-9","8-8-8","7-7-7")
                            and  `ctime` > date_format(date_sub(Now(),interval 5 MINUTE),"%Y-%m-%d %H:%i:%s")
                            ) as ta
                            where uid not in (select uid from log_activities where actid=:actid  and ctime between date_format(Now(),"%Y-%m-%d 00:00:00") and date_format(Now(),"%Y-%m-%d 23:59:59"))';
                }elseif ($singleO['standard']==2){
                            $sql2 = 'select uid from
                            (SELECT distinct uid FROM `zjh`.`log_coin_records` where
                            card_num in ("2-2-2","3-3-3","4-4-4","5-5-5","6-6-6")
                            and  `ctime` > date_format(date_sub(Now(),interval 5 MINUTE),"%Y-%m-%d %H:%i:%s")
                            ) as ta
                            where uid not in (select uid from log_activities where actid=:actid  and ctime between date_format(Now(),"%Y-%m-%d 00:00:00") and date_format(Now(),"%Y-%m-%d 23:59:59"))';
                }
    
                    $resgids = $db->createCommand($sql2)
                            ->bindValues([':actid'=>$singleO['id']])
                            ->queryAll();
                            if (count($resgids)>0){
                            foreach ($resgids as $gids){
                            //                            var_dump($gids);
                            //                            return false;
                                $gid = $gids['uid'];
                                $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                       values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                       ';
                            $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                                $maillog = new LogMail();
                            $maillog->gid=$gid;
                                $maillog->from_id=0;
                                $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                                $maillog->content=$maillog->title." 获得 ";
                                foreach ($singleO as $k=>$v)
                                {
                                if ($v!=0){
                                if ($k=="diamond"){
                                    $maillog->content.=$v."钻石";
                                    }elseif ($k=="coin"){
                                        $maillog->content.=$v."金币";
                                    }elseif ($k=="vcard_g"){
                                        $maillog->content.=$v."VIP金卡";
                                    }elseif ($k=="vcard_s"){
                                        $maillog->content.=$v."VIP银卡";
                                    }elseif ($k=="vcard_c"){
                                        $maillog->content.=$v."VIP铜卡";
                                    }
                                    }
                                    }
                                        $maillog->content.=" 系统已经自动发放到您的账户中。";
                                        $maillog->ctime=date('Y-m-d H:i:s');
                                        $maillog->status=0;
                                        $transaction = $db->beginTransaction();
                                        try {
                                        $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                            ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                                                $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                                                $maillog->save();
                                                    // ... 执行其他 SQL 语句 ...
                                                    $transaction->commit();
                                                    echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                                        } catch(Exception $e) {
                                        Yii::info("act trans failed now rollback".print_r($e,true));
                                        $transaction->rollBack();
                                        echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                                        }
            }
            }else {
            Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
            }
                    echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
    
    }
                        return true;
    }else {
            Yii::info("noact valid");
                echo "no act avalible~~! <br>";
                return false;
         }
    }
    public static function actFirst()
                {//单笔首充活动type9
                $db = Yii::$app->db;
                $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
    from gm_optact where status=0 and act_type='.Acts::RechargeFirstPrice.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
    and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
        $res = $db->createCommand($sql)->queryAll();
            if (count($res)>0){
            //活动列表不为空
            foreach ($res as $singleO){//每个活动
                if($singleO['standard']>0){
                $sql2 = 'select uid from
                    (select uid,fee,utime from (SELECT `playerid` as uid,fee,min(utime) as utime
                        FROM  `gm_orderlist`
                        where
                        `status` =2
                        and `source`!="Sms"
						GROUP BY `playerid` )as tt
						where utime between :bgtm and :endtm
						and fee = :standard) as ta
                        where uid not in (select uid from log_activities where actid=:actid)';
                    $resgids = $db->createCommand($sql2)
                        ->bindValues([':bgtm'=>$singleO['begin_tm'],':endtm'=>$singleO['end_tm'],':standard'=>$singleO['standard'],':actid'=>$singleO['id']])
                        ->queryAll();
                        if (count($resgids)>0){
                        foreach ($resgids as $gids){
                        //                            var_dump($gids);
                        //                            return false;
                            $gid = $gids['uid'];
                            $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                   values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                   ';
                            $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                                $maillog = new LogMail();
                            $maillog->gid=$gid;
                                    $maillog->from_id=0;
                                    $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                                    $maillog->content=$maillog->title." 获得 ";
                                    foreach ($singleO as $k=>$v)
                                        {
                                        if ($v!=0){
                                        if ($k=="diamond"){
                                            $maillog->content.=$v."钻石";
                                            }elseif ($k=="coin"){
                                            $maillog->content.=$v."金币";
                                            }elseif ($k=="vcard_g"){
                                            $maillog->content.=$v."VIP金卡";
                                            }elseif ($k=="vcard_s"){
                                                $maillog->content.=$v."VIP银卡";
                                                }elseif ($k=="vcard_c"){
                                                $maillog->content.=$v."VIP铜卡";
                                                }
                                                }
                                            }
                                    $maillog->content.=" 系统已经自动发放到您的账户中。";
                                        $maillog->ctime=date('Y-m-d H:i:s');
                                        $maillog->status=0;
                                        $transaction = $db->beginTransaction();
                                            try {
                                            $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid']==""?0:$singleO['propid'],':propnum'=>$singleO['propnum'],
                                                ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                                                $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                                                $maillog->save();
                                                // ... 执行其他 SQL 语句 ...
                                                    $transaction->commit();
                                                        echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                                                    } catch(Exception $e) {
                                                        Yii::info("act trans failed now rollback".print_r($e,true));
                                                            $transaction->rollBack();
                                                                echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                                                        }
                    }
                    }else {
                        Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                        echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
                        }
                        echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
                    }else {
                        echo "standard is 0";
                    }
                }
                return true;
            }else {
                Yii::info("noact valid");
                echo "no act avalible~~! <br>";
                return false;
            }
        }
        
    public static function actRechargeSinglePrice()
    {//充值单笔金额必返
        $db = Yii::$app->db;
        $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
    from gm_optact where status=0 and act_type='.Acts::RechargePriceAll.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
    and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
        $res = $db->createCommand($sql)->queryAll();
        if (count($res)>0){
            //活动列表不为空
            foreach ($res as $singleO){//每个活动
                if($singleO['standard']>0){
                    $sql2 = 'SELECT  `playerid`  as uid,orderid
            FROM  `gm_orderlist`
            where
                `utime` BETWEEN :bgtm and :endtm
                        and `status` =2
                        and `source`!="Sms"
                        and round(fee,0) = :standard 
                        and orderid not in (select `marks` from log_activities where actid=:actid)';
                    $resgids = $db->createCommand($sql2)
                    ->bindValues([':bgtm'=>$singleO['begin_tm'],':endtm'=>$singleO['end_tm'],':standard'=>$singleO['standard'],':actid'=>$singleO['id']])
                    ->queryAll();
                    if (count($resgids)>0){
                        foreach ($resgids as $gids){
                            //                            var_dump($gids);
                            //                            return false;
                            $gid = $gids['uid'];
                            $orderid = $gids['orderid'];
                            $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                ';
                            $sql2='insert into log_activities(uid,actid,marks) values(:gid,:actid,:marks)';
                            $maillog = new LogMail();
                            $maillog->gid=$gid;
                            $maillog->from_id=0;
                            $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                            $maillog->content=$maillog->title." 获得 ";
                            foreach ($singleO as $k=>$v)
                            {
                                if ($v!=0){
                                    if ($k=="diamond"){
                                        $maillog->content.=$v."钻石";
                                    }elseif ($k=="coin"){
                                        $maillog->content.=$v."金币";
                                    }elseif ($k=="vcard_g"){
                                        $maillog->content.=$v."VIP金卡";
                                    }elseif ($k=="vcard_s"){
                                        $maillog->content.=$v."VIP银卡";
                                    }elseif ($k=="vcard_c"){
                                        $maillog->content.=$v."VIP铜卡";
                                    }
                                }
                            }
                            $maillog->content.=" 系统已经自动发放到您的账户中。";
                            $maillog->ctime=date('Y-m-d H:i:s');
                            $maillog->status=0;
                            $transaction = $db->beginTransaction();
                            try {
                                $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                    ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                                $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id'],':marks'=>$orderid])->execute();
                                $maillog->save();
                                // ... 执行其他 SQL 语句 ...
                                $transaction->commit();
                                echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                            } catch(Exception $e) {
                                Yii::info("act trans failed now rollback".print_r($e,true));
                                $transaction->rollBack();
                                echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                            }
                        }
                    }else {
                        Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                        echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
                    }
                    echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
                }else {
                    echo "standard is 0";
                }
            }
            return true;
        }else {
            Yii::info("noact valid");
            echo "no act avalible~~! <br>";
            return false;
        }
        }
        
        public static function actSlotTimes()
        {//水浒传次数奖励
        $db = Yii::$app->db;
        $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
    from gm_optact where status=0 and act_type='.Acts::SlotTimes.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
    and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
        $res = $db->createCommand($sql)->queryAll();
        if (count($res)>0){
            //活动列表不为空
            foreach ($res as $singleO){//每个活动
                if($singleO['standard']>0){
                    $sql2 = 'select uid from
                    (SELECT uid,count(`change_coin`) as ct
FROM `zjh`.`log_coin_records`
WHERE `change_type` =34
and `change_coin` <0
and ctime between :bgtm and :endtm
GROUP BY `uid` HAVING ct >:standard
                        ) as ta
                        where uid not in (select uid from log_activities where actid=:actid)';
                    $resgids = $db->createCommand($sql2)
                    ->bindValues([':bgtm'=>$singleO['begin_tm'],':endtm'=>$singleO['end_tm'],':standard'=>$singleO['standard'],':actid'=>$singleO['id']])
                    ->queryAll();
                    if (count($resgids)>0){
                        foreach ($resgids as $gids){
                            //                            var_dump($gids);
                            //                            return false;
                            $gid = $gids['uid'];
                            $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                   values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                   ';
                            $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                            $maillog = new LogMail();
                            $maillog->gid=$gid;
                            $maillog->from_id=0;
                            $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                            $maillog->content=$maillog->title." 获得 ";
                            foreach ($singleO as $k=>$v)
                            {
                                if ($v!=0){
                                    if ($k=="diamond"){
                                        $maillog->content.=$v."钻石";
                                    }elseif ($k=="coin"){
                                        $maillog->content.=$v."金币";
                                    }elseif ($k=="vcard_g"){
                                        $maillog->content.=$v."VIP金卡";
                                    }elseif ($k=="vcard_s"){
                                        $maillog->content.=$v."VIP银卡";
                                    }elseif ($k=="vcard_c"){
                                        $maillog->content.=$v."VIP铜卡";
                                    }
                                }
                            }
                            $maillog->content.=" 系统已经自动发放到您的账户中。";
                            $maillog->ctime=date('Y-m-d H:i:s');
                            $maillog->status=0;
                            $transaction = $db->beginTransaction();
                            try {
                                $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                    ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                                $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                                $maillog->save();
                                // ... 执行其他 SQL 语句 ...
                                $transaction->commit();
                                echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                            } catch(Exception $e) {
                                Yii::info("act trans failed now rollback".print_r($e,true));
                                $transaction->rollBack();
                                echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                            }
                        }
                    }else {
                        Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                        echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
                    }
                    echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
                }else {
                    echo "standard is 0";
                }
            }
            return true;
        }else {
            Yii::info("noact valid");
            echo "no act avalible~~! <br>";
            return false;
        }
     }
     public static function actWarWinFour()
     {//百人四门全胜
     $db = Yii::$app->db;
     $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
    from gm_optact where status=0 and act_type='.Acts::WarWinner.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
    and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
     $res = $db->createCommand($sql)->queryAll();
     if (count($res)>0){
         //活动列表不为空
         foreach ($res as $singleO){//每个活动
                 $sql2 = 'select distinct uid from (SELECT `account_id` as uid 
                        FROM  log_bet_4 
						where stime between :bgtm and :endtm ) as ta
                        where uid not in (select uid from log_activities where actid=:actid)';
                 $resgids = $db->createCommand($sql2)
                 ->bindValues([':bgtm'=>$singleO['begin_tm'],':endtm'=>$singleO['end_tm'],':actid'=>$singleO['id']])
                 ->queryAll();
                 if (count($resgids)>0){
                     foreach ($resgids as $gids){
                         //                            var_dump($gids);
                         //                            return false;
                         $gid = $gids['uid'];
                         $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                   values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                   ';
                         $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                         $maillog = new LogMail();
                         $maillog->gid=$gid;
                         $maillog->from_id=0;
                         $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                         $maillog->content=$maillog->title." 获得 ";
                         foreach ($singleO as $k=>$v)
                         {
                             if ($v!=0){
                                 if ($k=="diamond"){
                                     $maillog->content.=$v."钻石";
                                 }elseif ($k=="coin"){
                                     $maillog->content.=$v."金币";
                                 }elseif ($k=="vcard_g"){
                                     $maillog->content.=$v."VIP金卡";
                                 }elseif ($k=="vcard_s"){
                                     $maillog->content.=$v."VIP银卡";
                                 }elseif ($k=="vcard_c"){
                                     $maillog->content.=$v."VIP铜卡";
                                 }
                             }
                         }
                         $maillog->content.=" 系统已经自动发放到您的账户中。";
                         $maillog->ctime=date('Y-m-d H:i:s');
                         $maillog->status=0;
                         $transaction = $db->beginTransaction();
                         try {
                             $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                 ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                             $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                             $maillog->save();
                             // ... 执行其他 SQL 语句 ...
                             $transaction->commit();
                             echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                         } catch(Exception $e) {
                             Yii::info("act trans failed now rollback".print_r($e,true));
                             $transaction->rollBack();
                             echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                         }
                     }
                 }else {
                     Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                     echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
                 }
                 echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
         }
         return true;
     }else {
         Yii::info("noact valid");
         echo "no act avalible~~! <br>";
         return false;
     }
     }
     
     public static function actRechargeManTomorrow()
     {//满送活动
         $db = Yii::$app->db;
         $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
    from gm_optact where status=0 and act_type='.Acts::RechargeManTomorrow.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
    and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
         $res = $db->createCommand($sql)->queryAll();
         if (count($res)>0){
             //活动列表不为空
             foreach ($res as $singleO){//每个活动
                 if($singleO['standard']>0){
                     $sql2 = 'select uid from
                        (SELECT `playerid` as uid, sum(fee) as total
                        FROM  `gm_orderlist`
                        where
                        `utime` BETWEEN date_format(date_sub(Now(),interval 1 DAY),"%Y-%m-%d 00:00:00") and date_format(date_sub(Now(),interval 1 DAY),"%Y-%m-%d 23:59:59") 
                        and `status` =2
                        and `source`!="Sms"
                        GROUP BY `playerid` HAVING total >= :standard) as ta
                        where uid not in (select uid from log_activities where actid=:actid and ctime between date_format(Now(),"%Y-%m-%d 00:00:00") and date_format(Now(),"%Y-%m-%d 23:59:59"))';
                     $resgids = $db->createCommand($sql2)
                     ->bindValues([':standard'=>$singleO['standard'],':actid'=>$singleO['id']])
                     ->queryAll();
                     if (count($resgids)>0){
                         foreach ($resgids as $gids){
                             //                            var_dump($gids);
                             //                            return false;
                             $gid = $gids['uid'];
                             $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                   values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                   ';
                             $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                             $maillog = new LogMail();
                             $maillog->gid=$gid;
                             $maillog->from_id=0;
                             $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                             $maillog->content=$maillog->title." 获得 ";
                             foreach ($singleO as $k=>$v)
                             {
                                 if ($v!=0){
                                     if ($k=="diamond"){
                                         $maillog->content.=$v."钻石";
                                     }elseif ($k=="coin"){
                                         $maillog->content.=$v."金币";
                                     }elseif ($k=="vcard_g"){
                                         $maillog->content.=$v."VIP金卡";
                                     }elseif ($k=="vcard_s"){
                                         $maillog->content.=$v."VIP银卡";
                                     }elseif ($k=="vcard_c"){
                                         $maillog->content.=$v."VIP铜卡";
                                     }
                                 }
                             }
                             $maillog->content.=" 系统已经自动发放到您的账户中。";
                             $maillog->ctime=date('Y-m-d H:i:s');
                             $maillog->status=0;
                             $transaction = $db->beginTransaction();
                             try {
                                 $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                     ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                                 $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                                 $maillog->save();
                                 // ... 执行其他 SQL 语句 ...
                                 $transaction->commit();
                                 echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                             } catch(Exception $e) {
                                 Yii::info("act trans failed now rollback".print_r($e,true));
                                 $transaction->rollBack();
                                 echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                             }
                         }
                     }else {
                         Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                         echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
                     }
                     echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
                 }else {
                     echo "standard is 0";
                 }
             }
             return true;
         }else {
             Yii::info("noact valid");
             echo "no act avalible~~! <br>";
             return false;
         }
     }
     public static function actSslBet()
     {//时时彩满送
     $db = Yii::$app->db;
     $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
    from gm_optact where status=0 and act_type='.Acts::SSLBetCoin.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
    and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
     $res = $db->createCommand($sql)->queryAll();
     if (count($res)>0){
         //活动列表不为空
         foreach ($res as $singleO){//每个活动
             if($singleO['standard']>0){
                 $sql2 = 'select uid from
                        (SELECT uid,count(*)as ct,sum(`change_coin`)as total  FROM `zjh`.`log_coin_history` 
where `change_type` =4 and `ctime` BETWEEN date_format(date_sub(Now(),interval 1 DAY),"%Y-%m-%d 00:00:00") and date_format(date_sub(Now(),interval 1 DAY),"%Y-%m-%d 23:59:59") 
GROUP BY `uid` having abs(total)>:standard ORDER BY ct desc) as ta
                        where uid not in (select uid from log_activities where actid=:actid and ctime between date_format(Now(),"%Y-%m-%d 00:00:00") and date_format(Now(),"%Y-%m-%d 23:59:59"))';
                 $resgids = $db->createCommand($sql2)
                 ->bindValues([':standard'=>$singleO['standard'],':actid'=>$singleO['id']])
                 ->queryAll();
                 if (count($resgids)>0){
                     foreach ($resgids as $gids){
                         //                            var_dump($gids);
                         //                            return false;
                         $gid = $gids['uid'];
                         $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                   values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                   ';
                         $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                         $maillog = new LogMail();
                         $maillog->gid=$gid;
                         $maillog->from_id=0;
                         $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                         $maillog->content=$maillog->title." 获得 ";
                         foreach ($singleO as $k=>$v)
                         {
                             if ($v!=0){
                                 if ($k=="diamond"){
                                     $maillog->content.=$v."钻石";
                                 }elseif ($k=="coin"){
                                     $maillog->content.=$v."金币";
                                 }elseif ($k=="vcard_g"){
                                     $maillog->content.=$v."VIP金卡";
                                 }elseif ($k=="vcard_s"){
                                     $maillog->content.=$v."VIP银卡";
                                 }elseif ($k=="vcard_c"){
                                     $maillog->content.=$v."VIP铜卡";
                                 }
                             }
                         }
                         $maillog->content.=" 系统已经自动发放到您的账户中。";
                         $maillog->ctime=date('Y-m-d H:i:s');
                         $maillog->status=0;
                         $transaction = $db->beginTransaction();
                         try {
                             $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                 ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                             $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                             $maillog->save();
                             // ... 执行其他 SQL 语句 ...
                             $transaction->commit();
                             echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                         } catch(Exception $e) {
                             Yii::info("act trans failed now rollback".print_r($e,true));
                             $transaction->rollBack();
                             echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                         }
                     }
                 }else {
                     Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                     echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
                 }
                 echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
             }else {
                 echo "standard is 0";
             }
         }
         return true;
     }else {
         Yii::info("noact valid");
         echo "no act avalible~~! <br>";
         return false;
     }
     }
     public static function actGamePlayed()
     {//满送活动
     $db = Yii::$app->db;
     $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
    from gm_optact where status=0 and act_type='.Acts::GMPlayNum.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
    and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
     $res = $db->createCommand($sql)->queryAll();
     if (count($res)>0){
         //活动列表不为空
         foreach ($res as $singleO){//每个活动
             if($singleO['standard']>0){
                 $sql2 = 'select uid from
                        (SELECT uid,count(*)as ct,sum(`change_coin`)as total  FROM `zjh`.`log_coin_history` 
where `change_type` =1 and `ctime` BETWEEN date_format(date_sub(Now(),interval 1 DAY),"%Y-%m-%d 00:00:00") and date_format(date_sub(Now(),interval 1 DAY),"%Y-%m-%d 23:59:59") 
GROUP BY `uid` having ct>:standard ORDER BY ct desc) as ta
                        where uid not in (select uid from log_activities where actid=:actid and ctime between date_format(Now(),"%Y-%m-%d 00:00:00") and date_format(Now(),"%Y-%m-%d 23:59:59"))';
                 $resgids = $db->createCommand($sql2)
                 ->bindValues([':standard'=>$singleO['standard'],':actid'=>$singleO['id']])
                 ->queryAll();
                 if (count($resgids)>0){
                     foreach ($resgids as $gids){
                         //                            var_dump($gids);
                         //                            return false;
                         $gid = $gids['uid'];
                         $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                   values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                   ';
                         $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                         $maillog = new LogMail();
                         $maillog->gid=$gid;
                         $maillog->from_id=0;
                         $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                         $maillog->content=$maillog->title." 获得 ";
                         foreach ($singleO as $k=>$v)
                         {
                             if ($v!=0){
                                 if ($k=="diamond"){
                                     $maillog->content.=$v."钻石";
                                 }elseif ($k=="coin"){
                                     $maillog->content.=$v."金币";
                                 }elseif ($k=="vcard_g"){
                                     $maillog->content.=$v."VIP金卡";
                                 }elseif ($k=="vcard_s"){
                                     $maillog->content.=$v."VIP银卡";
                                 }elseif ($k=="vcard_c"){
                                     $maillog->content.=$v."VIP铜卡";
                                 }
                             }
                         }
                         $maillog->content.=" 系统已经自动发放到您的账户中。";
                         $maillog->ctime=date('Y-m-d H:i:s');
                         $maillog->status=0;
                         $transaction = $db->beginTransaction();
                         try {
                             $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                 ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                             $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                             $maillog->save();
                             // ... 执行其他 SQL 语句 ...
                             $transaction->commit();
                             echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                         } catch(Exception $e) {
                             Yii::info("act trans failed now rollback".print_r($e,true));
                             $transaction->rollBack();
                             echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                         }
                     }
                 }else {
                     Yii::info("no march act gid valid ,actid ".$singleO['id']." act_title ".$singleO['act_title']);
                     echo "no match gid trans actid ".$singleO['id']." act_title ".$singleO['act_title']."<br>";
                 }
                 echo " actid ".$singleO['id']." act_title ".$singleO['act_title']." fetch over!<br>";
             }else {
                 echo "standard is 0";
             }
         }
         return true;
     }else {
         Yii::info("noact valid");
         echo "no act avalible~~! <br>";
         return false;
     }
     }
      
     public static function actWarbetrank()
     {//
         $db = Yii::$app->db;
         $sql = 'select id,name,act_title,begin_tm,end_tm,standard,diamond,coin,propid,propnum,vcard_g,vcard_s,vcard_c
                    from gm_optact where status=0 and act_type='.Acts::WARBETTOPS.' and  begin_tm < date_format(Now(),"%Y-%m-%d %H:%i:%s")
                    and end_tm > date_format(Now(),"%Y-%m-%d %H:%i:%s")';
         $res = $db->createCommand($sql)->queryAll();
         if (count($res)>0){
             //活动列表不为空
         
             $sql2 = 'call getBairenBetwin(date_format(date_sub(Now(),interval 1 day),"%Y-%m-%d 00:00:00"),date_format(date_sub(Now(),interval 1 day),"%Y-%m-%d 23:59:59"));';
             $resgids = $db->createCommand($sql2)->queryAll();
             if (count($resgids)>0){//有排行
                 foreach ($resgids as $K=>$gids){
                     //$k 是下标
                     $rank = $K+1;
                     foreach ($res as $singleO){//每个排名的奖励
                         if($rank<=$singleO['standard'])
                         {//排名1的时候
                             $gid = $gids['uid'];
                             $sql1='insert into log_actrewards(gid,point,coin,propid,propnum,card_g,card_s,card_c,`status`,ctime,change_type,`desc`)
                                                   values(:gid,:point,:coin,:propid,:propnum,:card_g,:card_s,:card_c,1,:ctime,22,:desc)
                                                   ';
                             $sql2='insert into log_activities(uid,actid) values(:gid,:actid)';
                             $maillog = new LogMail();
                             $maillog->gid=$gid;
                             $maillog->from_id=0;
                             $maillog->title="感谢您参与活动 ".$singleO['act_title'];
                             $maillog->content=$maillog->title." 获得 ";
                             foreach ($singleO as $k=>$v)
                             {
                                 if ($v!=0){
                                     if ($k=="diamond"){
                                         $maillog->content.=$v."钻石";
                                     }elseif ($k=="coin"){
                                         $maillog->content.=$v."金币";
                                     }elseif ($k=="vcard_g"){
                                         $maillog->content.=$v."VIP金卡";
                                     }elseif ($k=="vcard_s"){
                                         $maillog->content.=$v."VIP银卡";
                                     }elseif ($k=="vcard_c"){
                                         $maillog->content.=$v."VIP铜卡";
                                     }
                                 }
                             }
                             $maillog->content.=" 系统已经自动发放到您的账户中。";
                             $maillog->ctime=date('Y-m-d H:i:s');
                             $maillog->status=0;
                             $fd=LogActivities::find()->where('uid = '.$gid.' and actid='.$singleO['id'].' and date_format(ctime,"%Y-%m-%d")="'.date('Y-m-d').'" ')->count();
                             if ($fd>0)
                             {
                                 echo "user has been getx".$gid." actid ".$singleO['id']." date: ".date('Y-m-d H:i:s');
                             }else {
                                 echo "now test : actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";  
                                 $transaction = $db->beginTransaction();
                                 try {
                                     $db->createCommand($sql1)->bindValues([':gid'=>$gid,':point'=>$singleO['diamond'],':coin'=>$singleO['coin'],':propid'=>$singleO['propid'],':propnum'=>$singleO['propnum'],
                                         ':card_g'=>$singleO['vcard_g'],':card_s'=>$singleO['vcard_s'],':card_c'=>$singleO['vcard_c'],':ctime'=>date('Y-m-d H:i:s'),':desc'=>$singleO['act_title']])->execute();
                                     $db->createCommand($sql2)->bindValues([':gid'=>$gid,':actid'=>$singleO['id']])->execute();
                                     $maillog->save();
                                     // ... 执行其他 SQL 语句 ...
                                     $transaction->commit();
                                     echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans succ <br>";
                                 } catch(Exception $e) {
                                     Yii::info("act trans failed now rollback".print_r($e,true));
                                     $transaction->rollBack();
                                     echo "actid:".$singleO['id'].$singleO['act_title']." gid ".$gid." trans failed <br>";
                                 }
                             }
                             break;
                         }
                     }
                 }
             }
             else {
                 //没有排行榜
                 echo "no war rank ";
             }
             return true;
         }else {
             Yii::info("noact war rank  valid");
             echo "no act war rank  avalible~~! <br>";
             return false;
         }
     }
     
}