<?php
namespace app\components;
use yii;
use yii\helpers\Html;
class checkdb{
    public static function BanIpgid($ip)
    {
        $sql='call banShuahaoListWithip("'.$ip.'") ';
        $db=Yii::$app->db;
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        $msg="No gid found";
        if (count($res)>0){
            $msg = "封号信息<br>";
            foreach ($res as $a=>$v){
                $mx=[];
                if ($a==0)
                {
                    foreach ($v as $kk=>$vv)
                    { 
                        array_push($mx, $kk);
                    }
                    $msg.=join($mx, '|')."\n<br>";
                } 
                $mx=[];
                foreach ($v as $kk=>$vv)
                { 
                   array_push($mx, $vv); 
                }
                $msg.=join($mx, '|')."\n<br>";
            }
        }
        return $msg;
    }
    
    public static function CheckFade(){
        $sql='SELECT request_ip,count(distinct `gid`) as cn,city,isp FROM `log_userrequst` 
            WHERE  ctime >date_format(date_sub(Now(),interval 60 MINUTE),"%Y-%m-%d %H:%i:%s") 
            group by request_ip having cn >20 order by cn desc ';
        $db=Yii::$app->db_readonly;
        
        $res=$db->createCommand($sql)
            //          ->bindValues($params)
            ->queryAll();
        if (count($res)>0){
            $title="!刷号!以下IP近60分钟超过10个id登录";
//             $content = '<div class="col-sm-5">
//             <table class="table table-striped table-bordered detail-view col-sm-10" style="border: 1px solid #ddd;">
//             <tbody >';
//             $content.="<tr><td>IP</td><td>gid数</td><td>城市</td><td>运营商</td></tr>";
            $msg = "<!!疑似刷号快乐三张!!>以下IP近60分钟超过20个id登录";
            foreach ($res as $v){
                $mx=[];
                foreach ($v as $kk=>$vv)
                {
                    if ($kk == "request_ip"){
                        checkdb::BanIpgid($vv);
                        $vv = Html::a($vv,Yii::$app->getRequest()->hostInfo."/zjhadmin/banip?ip=".$vv);
                    }
                    array_push($mx, $kk.":".$vv);
                }
                $msg.=join($mx, '|')."\n";
//                 $content.='<tr><td>'.$v['request_ip']."</td><td>".$v['cn']."</td><td>".$v["city"]."</td><td>".$v["isp"]."</td></tr>";
            }
//             $content.='</tbody></table>
//             </div>';
//             $mail= \Yii::$app->mailer->compose('notify',['content'=>$content]);
//             $mail->setCc(array());
//             $mail->setSubject($title);
//             $mail->setHtmlBody($content);
//             $users=Yii::$app->params['mails'];
//             foreach ($users as $user){
//                 $mail->setTo($user);
//                 $mail->send();
//             }
            $wx = new wechatSend();
            $x=$wx->warningTowx($msg);
            Yii::error('wechat send msg:'.$msg.'result:'.json_encode($x),'wxapi');
//             return json_encode($x);
            return true;
        }
        return true;
    }
    
    public static function checkCoin()
    {
        $sql='SELECT t2.c_name as "变更类型",sum(t1.change_coin) as "总金币" 
            FROM `log_coin_records`t1,`cfg_coin_changetype`t2  
            WHERE t1.ctime> date_format(date_sub(Now(),interval 30 MINUTE),"%Y-%m-%d %H:%i:%s") and t1.change_type=t2.cid group by t2.c_name;';
        $db=Yii::$app->db_readonly;
        
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
            ->queryAll();
    }
    
    public static function checkSms()
    {
        $sql='call lastOneHourSmsCheck();';
        $db=Yii::$app->db_readonly;
        
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        if (count($res)>0){
            $msg = "同IP短信充值超过20元(上一小时)。";
            foreach ($res as $v)
            {
                $msg.=implode('|', $v);
                $msg.="\n";
            }
            $wx = new wechatSend();
            $x=$wx->warningTowx($msg);
        }
        return true;
    }
    public static function checkYouyi()
    {
        $sql='select reg_channel,t2.channel_name,count(distinct t1.gid)as ct
             from gm_account_info t1,gm_channel_info t2 
            where t1.reg_time > date_format(date_sub(Now(),interval 2 MINUTE),"%Y-%m-%d %H:%i:%d")
            and t1.reg_channel=t2.cid
            group by reg_channel
            having ct >20
            ';
        $db=Yii::$app->db_readonly;
    
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        if (count($res)>0){
            $msg = "2分钟内单渠道注册大于20个号";
            foreach ($res as $v)
            {
                $msg.=implode('|', $v);
                $msg.="\n";
            }
            $wx = new wechatSend();
            $x=$wx->warningTowx($msg);
        }
        return true;
    }
    
    public static function checkTomuchWin()
    {
        $sql='call banBlackWinmuch();';
        $db=Yii::$app->db_readonly;
    
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        if (count($res)>0){
            $msg = "胜率过高新注册号。\n";
            $msg .= "gid|昵称|vip|现有金币(万)|胜|负|注册渠道|最后登录|注册时间\n";
            foreach ($res as $v)
            {
                $msg.=implode('|', $v);
                $msg.="\n";
            }
            $wx = new wechatSend();
            $x=$wx->warningTowx($msg);
        }
        return true;
    }
    
    public static function checkLargeCoinChange()
    {
        $sql='SELECT  t1.gid,t2.name,t2.power,t3.c_name,t1.change_coin,t1.after_coin,t1.after_all,t1.ctime 
            FROM `large_coin_change`t1,gm_player_info t2,cfg_coin_changetype t3 
            WHERE t1.gid=t2.account_id and t1.change_type=t3.cid and ABS(t1.change_coin)>500000000
            and t1.ctime> date_format(date_sub(Now(),interval 30 MINUTE),"%Y-%m-%d %H:%i") ';
        $db=Yii::$app->db_readonly;
        
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        if (count($res)>0){
            $title="<!!金币变化较大!!>以下帐号30分钟以内有单笔变更金币超过5亿";
//             $content = '<div class="col-sm-5">
//             <table class="table table-striped table-bordered detail-view col-sm-10" style="border: 1px solid #ddd;">
//             <tbody >';
//             $content.="<tr><td>UID|</td><td>昵称|</td><td>VIP等级|</td><td>变更类型|</td><td>变更金币数|</td><td>携带金币</td><td>全部金币</td><td>时间|</td></tr>";
            $msg = "<!!金币变化较大!!>以下帐号30分钟以内有单笔变更金币超过5亿";
            foreach ($res as $v){
                $mx=[];
                foreach ($v as $kk=>$vv)
                {
                    if($kk=="change_coin"){
                        $vv=Yii::$app->formatter->asInteger($vv/10000)."万";
                        array_push($mx, "变更金币:".$vv);
                    }elseif ($kk=="after_coin"){
                        if($vv>0)
                            $vv=Yii::$app->formatter->asInteger($vv/10000)."万";
                        array_push($mx, "携带:".$vv);
                    }elseif ($kk=="after_all"){
                        if($vv>0)
                            $vv=Yii::$app->formatter->asInteger($vv/10000)."万";
                        array_push($mx, "总身家:".$vv);
                    }else {
                        array_push($mx, $kk.":".$vv);
                    }
                }
                $msg.= join($mx, '|')."\n";
//                 $content.='<tr><td>'.$v['gid']."|</td><td>".$v["name"]."|</td><td>".$v["power"]."|</td><td>".$v["c_name"]."|</td><td>".Yii::$app->formatter->asInteger($v['change_coin']/10000)
//                 ."万|</td><td>".$v["name"]."|</td><td>".$v["after_coin"]."</td><td>".$v["ctime"]."</td></tr>";
            }
            Yii::error('wechat send  msg:'.$msg,'wxapi');
            $wx = new wechatSend();
            $x=$wx->warningTowx($msg);
//             Yii::error('wechat send  msg:'.$msg.'result:'.json_encode($x),'wxapi');
//             $content.='</tbody></table>
//             </div>';
//             $mail= \Yii::$app->mailer->compose('notify',['content'=>$content]);
//             $mail->setCc(array());
//             $mail->setSubject($title);
//             $mail->setHtmlBody($content);
//             $users=Yii::$app->params['mails'];
//             foreach ($users as $user){
//                 $mail->setTo($user);
//                 $mail->send();
//             }
            
            return true;
        }
        return true;
    }
    
    public static function checkLargeGameChange()
    {
        $sql='SELECT  t1.gid,t2.name,t2.power,t3.c_name,t1.change_coin,t1.after_coin,t1.after_all,t1.ctime
            FROM `large_coin_change`t1,gm_player_info t2,cfg_coin_changetype t3
            WHERE t1.gid=t2.account_id and t1.change_type=t3.cid and t1.change_type=1 and ABS(t1.change_coin)>300000000
            and  t1.ctime  > date_format(date_sub(Now(),interval 5 MINUTE),"%Y-%m-%d %H:%i:%s") ';
        $db=Yii::$app->db_readonly;
    
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        if (count($res)>0){
            $title="<!!金币变化巨大!!>以下帐号5分钟以内有单笔游戏变更金币超过3亿";
            $content = '<div class="col-sm-5">
            <table class="table table-striped table-bordered detail-view col-sm-10" style="border: 1px solid #ddd;">
            <tbody >';
            $content.="<tr><td>UID|</td><td>昵称|</td><td>VIP等级|</td><td>变更类型|</td><td>变更金币数|</td><td>携带金币</td><td>全部金币</td><td>时间|</td></tr>";
            $msg = "<!!金币变化较大BUG!!>以下帐号5分钟以内有单笔游戏变更金币超过1亿";
            foreach ($res as $v){
                $mx=[];
                foreach ($v as $kk=>$vv)
                {
                    if($kk=="change_coin"){
                        $vv=Yii::$app->formatter->asInteger($vv/10000)."万";
                        array_push($mx, "变更金币:".$vv);
                    }elseif ($kk=="after_coin"){
                        if($vv>0)
                            $vv=Yii::$app->formatter->asInteger($vv/10000)."万";
                        array_push($mx, "携带:".$vv);
                    }elseif ($kk=="after_all"){
                        if($vv>0)
                            $vv=Yii::$app->formatter->asInteger($vv/10000)."万";
                        array_push($mx, "总身家:".$vv);
                    }else {
                        array_push($mx, $kk.":".$vv);
                    }
                }
                $msg.=join($mx, '|')."\n";
                $content.='<tr><td>'.$v['gid']."|</td><td>".$v["name"]."|</td><td>".$v["power"]."|</td><td>".$v["c_name"]."|</td><td>".Yii::$app->formatter->asInteger($v['change_coin']/10000)
                ."万|</td><td>".$v["name"]."|</td><td>".$v["after_coin"]."</td><td>".$v["ctime"]."</td></tr>";
            }
            $content.='</tbody></table>
            </div>';
            $wx = new wechatSend();
            $x=$wx->warningTowx($msg);
//             Yii::error('wechat send msg:'.$msg.'result:'.json_encode($x),'wxapi');
//             $mail= \Yii::$app->mailer->compose('notify',['content'=>$content]);
//             $mail->setCc(array());
//             $mail->setSubject($title);
//             $mail->setHtmlBody($content);
//             $users=Yii::$app->params['mails'];
//             foreach ($users as $user){
//                 $mail->setTo($user);
//                 $mail->send();
//             }
            
            return true;
        }
        return true;
    }
    public static function checkFailedcoin()
    {
        $sql='SELECT  t1.uid,t2.name,t2.power,t3.c_name,t1.change_coin,t1.after_coin,t1.after_all,t1.ctime
            FROM `log_failed_coin_records`t1,gm_player_info t2,cfg_coin_changetype t3
            WHERE t1.uid=t2.account_id and t1.change_type=t3.cid 
            and  t1.ctime  > date_format(date_sub(Now(),interval 2 MINUTE),"%Y-%m-%d %H:%i:%s") ';
        $db=Yii::$app->db_readonly;
    
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        if (count($res)>0){
            
            
        }
        
    }
    public static function checkLargeChange()
    {
        $sql='SELECT  t1.gid,t2.name,t2.power,t3.c_name,t1.change_coin,t1.after_coin,t1.after_all,t1.ctime
            FROM `large_coin_change`t1,gm_player_info t2,cfg_coin_changetype t3
            WHERE t1.gid=t2.account_id and t1.change_type=t3.cid and ABS(t1.change_coin)>800000000
            and t1.gid not in (33333,120121,11111)
            and  t1.ctime  > date_format(date_sub(Now(),interval 2 MINUTE),"%Y-%m-%d %H:%i:%s") ';
        $db=Yii::$app->db_readonly;
    
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        if (count($res)>0){
            $title="!重大变更,金币超8亿";
//             $content = '<div class="col-sm-5">
//             <table class="table table-striped table-bordered detail-view col-sm-10" style="border: 1px solid #ddd;">
//             <tbody >';
//             $content.="<tr><td>UID|</td><td>昵称|</td><td>VIP等级|</td><td>变更类型|</td><td>变更金币数|</td><td>携带金币</td><td>全部金币</td><td>时间|</td></tr>";
            $msg = "<!!金币变化较大BUG!!>以下帐号2分钟以内有单笔游戏变更金币超过8亿";
            foreach ($res as $v){
                $mx=[];
                foreach ($v as $kk=>$vv)
                {
                    if($kk=="change_coin"){
                        $vv=Yii::$app->formatter->asInteger($vv/10000)."万";
                        array_push($mx, "变更金币:".$vv);
                    }elseif ($kk=="after_coin"){
                        if($vv>0)
                            $vv=Yii::$app->formatter->asInteger($vv/10000)."万";
                        array_push($mx, "携带:".$vv);
                    }elseif ($kk=="after_all"){
                        if($vv>0)
                            $vv=Yii::$app->formatter->asInteger($vv/10000)."万";
                        array_push($mx, "总身家:".$vv);
                    }else {
                        array_push($mx, $kk.":".$vv);
                    }
                }
                $msg.=join($mx, '|')."\n";
//                 $content.='<tr><td>'.$v['gid']."|</td><td>".$v["name"]."|</td><td>".$v["power"]."|</td><td>".$v["c_name"]."|</td><td>".Yii::$app->formatter->asInteger($v['change_coin']/10000)
//                 ."万|</td><td>".$v["name"]."|</td><td>".$v["after_coin"]."</td><td>".$v["ctime"]."</td></tr>";
            }
//             $content.='</tbody></table>
//             </div>';
            $wx = new wechatSend();
            $x=$wx->warningTowx($msg);
            Yii::error('wechat send msg:'.$msg.'result:'.json_encode($x),'wxapi');
//             $mail= \Yii::$app->mailer->compose('notify',['content'=>$content]);
//             $mail->setCc(array());
//             $mail->setSubject($title);
//             $mail->setHtmlBody($content);
//             $users=Yii::$app->params['mails'];
//             foreach ($users as $user){
//                 $mail->setTo($user);
//                 $mail->send();
//             }
    
            return true;
        }
        return true;
    }
    
    
    public static function getSslper()
    {
        $sql='call getSslPercent("'.date("Y-m-d").'","'.date('Y-m-d H:i:s').'")';
        $db=Yii::$app->db_readonly;
        
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
            ->queryAll();
        $msg="结果|开奖次数|总局数|概率|回报|总返奖|总派奖人数\n";
        if (count($res)>0){
            foreach ($res as $v){
                $mx=[];
                foreach ($v as $kk=>$vv)
                {
                    if ($kk=="result"){
                        switch ($vv){
                            case 1:
                                $vv="对子";
                                break;
                            case 2:
                                $vv="顺子";
                                break;
                            case 3:
                                $vv="金花";
                                break;
                            case 4:
                                $vv="散牌";
                                break;
                            case 5:
                                $vv="顺金";
                                break;
                            case 6:
                                $vv="豹子";
                                break;
                            case 7:
                                $vv="3A";
                                break;
                            default:
                                break;
                        }
                    }
                    array_push($mx, $kk.":".$vv);
                }
                $msg.=join($mx, '|')."\n";
            }
        }
        return $msg;
    }
    
    public static function getSslWinner()
    {
        $sql='call getSslWinner("'.date("Y-m-d").'","'.date('Y-m-d H:i:s').'")';
        $db=Yii::$app->db_readonly;
    
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        $msg="gid|name|VIP|总奖金\n";
        if (count($res)>0){
            foreach ($res as $v){
                $mx=[];
                foreach ($v as $kk=>$vv)
                {
                    array_push($mx, $kk.":".$vv);
                }
                $msg.=join($mx, '|')."\n";
            }
        }
        return $msg;
    }
    
    public static function getRich()
    {
        $sql='SELECT t1.playerid as gid,sum(t1.fee) as totalfee, t3.name,t4.channel_name
FROM `gm_orderlist`t1,`gm_account_info` t2 ,`gm_player_info` t3,`gm_channel_info` t4
where t1.playerid=t2.gid and t1.playerid=t3.account_id and t2.reg_channel=t4.cid
and t1.`status`=2 and t1.utime>date_format(NOW(),"%Y-%m-%d")
GROUP BY gid having totalfee>200 order by totalfee desc limit 10';
        $db=Yii::$app->db_readonly;
    
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        $msg="gid|RMB|NAME|渠道\n";
        if (count($res)>0){
            foreach ($res as $v){
                $mx=[];
                foreach ($v as $kk=>$vv)
                {
                    array_push($mx, $kk.":".$vv);
                }
                $msg.=join($mx, '|')."\n";
            }
        }
        return $msg;
    }
    
    public static function getActData()
    {
        $sql='SELECT t1.uid,t2.name,t2.act_title, t3.name as nick,t3.power,t3.money
FROM `log_activities`t1,gm_optact t2,gm_player_info t3
where t1.actid=t2.id and t1.uid=t3.account_id ';
        $db=Yii::$app->db_readonly;
    
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        if (count($res)>0){
            $title="活动参与情况";
            $content = '<div class="col-sm-5">
            <table class="table table-striped table-bordered detail-view col-sm-10" style="border: 1px solid #ddd;">
            <tbody >';
            $content.="";
            
            foreach ($res as $v){
                
                $content.='<tr><td>'.$v['uid']."|</td><td>".$v["name"]."|</td><td>".$v["act_title"]."|</td><td>".$v["nick"]."|</td><td>".$v['power']."|</td><td>".$v["money"]."</td></tr>";
            }
            $content.='</tbody></table>
            </div>';
            
            $mail= \Yii::$app->mailer->compose('notify',['content'=>$content]);
            $mail->setCc(array());
            $mail->setSubject($title);
            $mail->setHtmlBody($content);
            $users=Yii::$app->params['mails'];
            foreach ($users as $user){
                $mail->setTo($user);
                $mail->send();
            }
    
            return true;
        }
        return true;
    }
}