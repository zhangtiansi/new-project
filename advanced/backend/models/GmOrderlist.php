<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "gm_orderlist".
 *
 * @property integer $id
 * @property integer $playerid
 * @property string $orderid
 * @property string $productid
 * @property string $reward
 * @property string $source
 * @property string $fee
 * @property string $transaction_id
 * @property string $transaction_time
 * @property integer $status
 * @property string $ctime
 * @property string $utime
 * @property integer $vipcard_g
 * @property integer $vipcard_s
 * @property integer $vipcard_c
 * @property string $price
 */
class GmOrderlist extends \yii\db\ActiveRecord
{
    const ORDER_NOT_PAY = 0;
    const ORDER_NOT_PAYED = 1;
    const ORDER_NOT_RECHARGED = 2;
    
    const DATA_TYPE_RECHARGE = 1;
    const DATA_TYPE_USER = 2;
    const DATA_TYPE_STAY2 = 3;
    const DATA_TYPE_STAY3 = 4;
    const DATA_TYPE_STAY7 = 5;
    const DATA_TYPE_STAYPAY = 6;
    
    public  $udate="";
    public $totalfee="";
    
    public $starttm="";
    public $endtm="";
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_orderlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['playerid', 'orderid', 'productid', 'reward', 'fee', 'status', 'ctime', 'price'], 'required'],
            [['playerid', 'status', 'vipcard_g', 'vipcard_s', 'vipcard_c'], 'integer'],
            [['transaction_time', 'ctime', 'utime','coin','card_kick','card_laba','card_rename'], 'safe'],
            [['orderid'], 'string', 'max' => 50],
            [['productid'], 'string', 'max' => 30],
            [['reward'], 'string', 'max' => 20],
            [['source'], 'string', 'max' => 10],
            [['fee', 'price'], 'string', 'max' => 11],
            [['transaction_id'], 'string', 'max' => 60],
            [['orderid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'playerid' => '玩家id',
            'orderid' => '订单号',
            'productid' => '产品id',
            'reward' => '获得钻石',
            'source' => '充值来源',
            'fee' => '扣费金额',
            'transaction_id' => '渠道扣费id',
            'transaction_time' => '渠道扣费时间',
            'status' => '状态',
            'ctime' => '创建时间',
            'utime' => '修改时间',
            'coin'=>'金币数',
            'card_kick'=>'踢人卡',
            'card_laba'=>'喇叭卡',
            'card_rename'=>'改名卡',
            'vipcard_g' => '金卡数',
            'vipcard_s' => '银卡数',
            'vipcard_c' => '铜卡数',
            'price' => '价格',
            'starttm'=>'起始时间',
            'endtm'=>'结束时间',
        ];
    }
    
    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        if ($this->status==1){
            if ($this->productid==GmMonthCard::PRODUCT_CARD_WEEK||$this->productid==GmMonthCard::PRODUCT_CARD_MONTH)
            {//周卡或者月卡充值到账，需要加相应的卡
                if (GmMonthCard::AddCard($this->playerid, $this->productid, $this->orderid))
                {
                    Yii::error("Order save addCard success ".$this->orderid,'buycard');
                }else {
                    Yii::error("Order save addCard failed ".$this->orderid,'buycard');
                }
            }
        }
    
    }
    
    public  static function getRecentCdata()
    { 
        $keyword = 'recentrechargedaily';
        $data = Yii::$app->cache[$keyword];
        $allres = [];
        if ($data === false||count($data)==0) {
            $db=Yii::$app->db_readonly;
            $sql='SELECT date_format(utime,"%Y%m%d") as cdate,"all" as source,sum(fee) as totalcash  FROM  gm_orderlist   WHERE status=2   group by  cdate  order by cdate desc limit 5';
        }else {
            $allres=$data;
        }
        return $allres;
    }
    public  static function getRecentUserdata()
    {
        $keyword = 'recentKeydata223';
        $data = Yii::$app->cache[$keyword];
        $allres = [];
        if ($data === false||count($data)==0) {
            $db=Yii::$app->db_readonly;
            $sqllist=[
                'select param_value as "当前在线" from  cfg_game_param where param_key="SYS_ONLINE"',
               'select count(distinct t1.ime) as "今日注册人数(ime去重去历史)" from  log_ime_register t1 where date_format(t1.reg_time,"%Y-%m-%d")=date_format(Now(),"%Y-%m-%d")',
               'select count(distinct t2.gid) as "今日登录人数" from log_userrequst t2 where date_format(t2.ctime,"%Y-%m-%d")=date_format(Now(),"%Y-%m-%d")',
               'select count(distinct t3.uid) as "今日活跃人数" from  log_coin_records t3 where date_format(t3.ctime,"%Y-%m-%d")=date_format(Now(),"%Y-%m-%d") and t3.change_type=1',  
               'select sum(fee) as "今日充值总数RMB" from gm_orderlist t1 where date_format(t1.utime,"%Y-%m-%d")=date_format(Now(),"%Y-%m-%d") and t1.status=2 and t1.fee>0',            
               'select count(distinct t1.playerid) as "今日充值人数" from gm_orderlist t1 where date_format(t1.utime,"%Y-%m-%d")=date_format(Now(),"%Y-%m-%d") and t1.status=2 and t1.fee>0',
               'select round(sum(coin)/80000,0) as "今日Agent收入RMB" FROM  log_customer t1,user t2  WHERE t1.coin>0 and t1.ops=t2.id and t2.role=3 and date_format(t1.ctime,"%Y-%m-%d")=date_format(now(),"%Y-%m-%d")',
            ];
            foreach ($sqllist as $sql){
                $res = $db->createCommand($sql)
    //          ->bindValues($params)
                ->queryAll();
                foreach ($res as $v){
                    foreach ($v as $k=>$val){
                        array_push($allres, ['k'=>$k,'v'=>$val]);
                    }
                }
                
            }
            $sql='select  t1.source,sum(fee) as totalfee from  gm_orderlist t1,gm_account_info t2
    where t1.status=2 and  t1.utime between date_format(Now(),"%Y-%m-%d 00:00:00") and  date_format(Now(),"%Y-%m-%d 23:59:59")
    and t1.playerid=t2.gid   group by source';
            $res = $db->createCommand($sql)
            //          ->bindValues($params)
            ->queryAll();
            foreach ($res as $k=>$v)
            {
                array_push($allres, ['k'=>$v['source']."-支付方式充值金额:",'v'=>$v['totalfee']]);
            }
//             $sql='select  t3.channel_name,count(distinct t2.gid) as totalreg from   gm_account_info t2,gm_channel_info t3
//     where date_format(t2.reg_time,"%Y-%m-%d")=date_format(Now(),"%Y-%m-%d")  and t2.reg_channel=t3.cid   group by channel_name';
//             $res = $db->createCommand($sql)
//             //          ->bindValues($params)
//             ->queryAll();
//             foreach ($res as $k=>$v)
//             {
//                 array_push($allres, ['k'=>$v['channel_name']."-渠道注册人数:",'v'=>$v['totalreg']]);
//             }
            Yii::$app->cache->set($keyword, $allres,120);
        }else {
            $allres=$data;
        }
        return $allres;
    }
    public static function getRecentRecharge()
    {
        $db=Yii::$app->db_readonly;
        $allres=[];
        $sql='select  t1.source,sum(fee) as totalfee from  gm_orderlist t1,gm_account_info t2
    where t1.status=2 and  t1.utime between date_format(Now(),"%Y-%m-%d 00:00:00") and  date_format(Now(),"%Y-%m-%d 23:59:59")
    and t1.playerid=t2.gid   group by source';
        $res = $db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        foreach ($res as $k=>$v)
        {
            array_push($allres, ['k'=>$v['source']."-支付方式充值金额:",'v'=>$v['totalfee']]);
        }
        return $allres;
    }
    public static function getYesterdayRecharge($days)
    {
        $db=Yii::$app->db_readonly;
        $allres=[];
        $sql='select  t1.source,sum(fee) as totalfee from  gm_orderlist t1,gm_account_info t2
    where t1.status=2 and   t1.utime between date_format(date_sub(Now(),interval '.$days.' day),"%Y-%m-%d 00:00:00") and  date_format(date_sub(Now(),interval '.$days.' day),"%Y-%m-%d 23:59:59") 
    and t1.playerid=t2.gid   group by source';
        $res = $db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        foreach ($res as $k=>$v)
        {
            array_push($allres, ['k'=>$v['source']."-支付方式充值金额:",'v'=>$v['totalfee']]);
        }
        return $allres;
    }
    public static function getRecentDataWX()
    {
        $keyword = 'recentDataWxx12';
        $data = Yii::$app->cache[$keyword];
        $content="";
        if ($data === false||count($data)==0) {
            $td = date('Y-m-d');
            $ar=TdSummary::findOne(['cdate'=>$td]);
            $db=Yii::$app->db_readonly;
            $allres=[];
//             $sql='select sum(gift_num)/8 from log_gift where from_uid in (select account_id from gm_player_info where status=98) and to_uid not in (select account_id from gm_player_info where status=98) and gift_id=11 and ctime>:td';
//             $resChuhuo = $db->createCommand($sql)->bindValues([':td'=>$td])->queryScalar();
//             $sql2='select sum(gift_num)/8.5 from log_gift where to_uid in (select account_id from gm_player_info where status=98) and from_uid not in (select account_id from gm_player_info where status=98) and gift_id=11 and ctime>:td';
//             $resHuiShou = $db->createCommand($sql2)->bindValues([':td'=>$td])->queryScalar();
//             $sql3='select SUM(tt) as totalbet,COUNT(war_id)as betnum,round(SUM(tt)/COUNT(war_id)/10000,1) as betavg 
//                 from  (SELECT `war_id`,(`men1_coin`+`men2_coin` +`men3_coin` +`men4_coin` ) as tt,abs(`banker_coin`) as banker_coin 
//                        FROM `zjh`.`log_war_record` where `ctime` >:td GROUP BY `war_id` ) as tb  WHERE tt>0';
//             $resWarinfo = $db->createCommand($sql3)->bindValues([':td'=>$td])->queryOne();
            $sqldl = "select sum(money+point_box) as mon from gm_player_Info where `status`=98;";
            $agentCoin =  $db->createCommand($sqldl)->queryScalar();
//             $agentCoin = (GmPlayerInfo::findOne('120121')->money+GmPlayerInfo::findOne('120121')->point_box);
//             $agentCoin += (GmPlayerInfo::findOne('129046')->money+GmPlayerInfo::findOne('129046')->point_box);
//             $agentCoin += (GmPlayerInfo::findOne('33333')->money+GmPlayerInfo::findOne('33333')->point_box);
//             $agentCoin += (GmPlayerInfo::findOne('11111')->money+GmPlayerInfo::findOne('11111')->point_box);
            if (is_object($ar)){
                $res=$ar->attributes;
                $cont="今日当前数据\n";
                $cont.="充值总数：<<<".Yii::$app->formatter->asInteger(($res['recharge_total']+intval($res['agent_cash']==null?0:$res['agent_cash']))).">>>元\n";
                $cont.="客户端充值：【".$res['recharge_total']."】元".$res['recharge_num']."人，arpu:".Yii::$app->formatter->asDecimal($res['recharge_num']==0?0:$res['recharge_total']/$res['recharge_num'],1)."\n";
                $cont.="Agent：【".$res['agent_cash']."】元 人数".$res['agent_num']."人,arpu:".Yii::$app->formatter->asDecimal($res['agent_num']==0?0:$res['agent_cash']/$res['agent_num'],1)."\n";
                $cont.="注册人数IME：【".$res['reg_num']."】，注册活跃".$res['regact_num']."\n";
                $cont.="登录人数：".$res['login_num']."，活跃人数".$res['active_num']."\n";
                $cont.="最大在线：".$res['max_online']."，当前在线".$res['now_online']."\n";
                $cont.="时时乐总押注：【".round($res['ssl_bet']/10000)."】亿，总返奖".round($res['ssl_reward']/10000,2)."亿,净消耗【".round(($res['ssl_bet']-$res['ssl_reward'])/10000,2)."亿】\n"; 
                $cont.="水浒传玩家净入:【";
                $cont.=isset($res['slot_coin'])?round($res['slot_coin']/100000000,2)."亿】":"0】";
                $cont.="参与人次:【";
                $cont.=isset($res['slot_num'])?$res['slot_num']:"0";
                $cont.="】参与人数:【";
                $cont.=isset($res['slot_player'])?$res['slot_player']:"0";
                $cont.="】\n";
                $cont.="百人数据：";
                $cont.=isset($res['hundred_coin'])?"玩家净盈利【".round($res['hundred_coin']/100000000,2)."亿】":"【数据异常】";
                $cont.="参与人数:【";
                $cont.=isset($res['hundred_num'])?$res['hundred_num']:"0";
                $cont.="】坐庄人数:【";
                $cont.=isset($res['hundred_zhuang'])?$res['hundred_zhuang']:"0";
                $cont.="】\n";
                $cont.="百人总押注:【".round($res['hundred_totalbet']/100000000,2)."】亿 局数：".$res['hundred_betnum']." 平均押注：【".$res['hundred_betavg']."】万\n"; 
                $cont.="AgentOut[".Yii::$app->formatter->asInteger($res['agent_out']==""?0:$res['agent_out'])."]，IN[".Yii::$app->formatter->asInteger($res['agent_in']==""?0:$res['agent_in'])."],Last[[".Yii::$app->formatter->asInteger(intval($agentCoin/100000000))."]]亿金币\n";
                $recentRecharge=GmOrderlist::getRecentRecharge();
                foreach ($recentRecharge as $K=>$V){
                    $cont.=$V['k'].$V['v']."\n";
                }
                $content=$cont;
            }else {
                $content="欢迎你，xxx。\n 今天天气不错";
            }
            Yii::$app->cache->set($keyword, $content,60);
        }else {
            $content=$data;
        }
        return $content;
    }
    public static function getSSLToday()
    {
        $keyword = 'recentDataSSL';
        $data = Yii::$app->cache[$keyword];
        $content="";
        if ($data === false||count($data)==0) {
            $db=Yii::$app->db_readonly;
            $allres=[];
            $sql='select t1.gid,t2.name,reward,betall from rank_ssl_daily t1,gm_player_info t2 where t1.gid=t2.account_id order by reward desc limit 10';
            $resAll = $db->createCommand($sql)->queryAll();
            $cont = "时时乐今日榜单\n 昵称||返奖(万)||押注(万)\n";
            foreach ($resAll as $V){
                $cont.=$V['name']."||".$V['reward']."||".$V['betall']."\n";
            }
            $content=$cont;
            Yii::$app->cache->set($keyword, $content,60);
        }else {
            $content=$data;
        }
        return $content;
    }
    
    public static function getYesterdayDataWX($days)
    {
        $dt = date('Y-m-d',strtotime("-".$days." day"));
        $keyword = 'YesterdayDataWx'.$dt;
        $data = Yii::$app->cache[$keyword];
        $content="";
        if ($data === false||count($data)==0) {
            $bgtd = date('Y-m-d 00:00:00',strtotime("-".$days." day"));
            $endtd = date('Y-m-d 23:59:59',strtotime("-".$days." day"));
            $ar=TdSummary::findOne(['cdate'=>$dt]);
//             $db=Yii::$app->db_readonly;
//             $sql='select sum(gift_num)/8 from log_gift where from_uid in (select account_id from gm_player_info where status=98) and to_uid not in (select account_id from gm_player_info where status=98) and gift_id=11 and ctime>:td and ctime <:endtd';
//             $resChuhuo = $db->createCommand($sql)->bindValues([':td'=>$bgtd,':endtd'=>$endtd])->queryScalar();
//             $sql2='select sum(gift_num)/8.5 from log_gift where to_uid in (select account_id from gm_player_info where status=98) and from_uid not in (select account_id from gm_player_info where status=98) and gift_id=11 and ctime>:td and ctime <:endtd';
//             $resHuiShou = $db->createCommand($sql2)->bindValues([':td'=>$bgtd,':endtd'=>$endtd])->queryScalar();
//             $sql3='select SUM(tt) as totalbet,COUNT(war_id)as betnum,round(SUM(tt)/COUNT(war_id)/10000,1) as betavg
//                 from  (SELECT `war_id`,(`men1_coin`+`men2_coin` +`men3_coin` +`men4_coin` ) as tt,abs(`banker_coin`) as banker_coin
//                        FROM `zjh`.`log_war_record` where ctime>:td and ctime <:endtd GROUP BY `war_id` ) as tb  WHERE tt>0';
//             $resWarinfo = $db->createCommand($sql3)->bindValues([':td'=>$bgtd,':endtd'=>$endtd])->queryOne();
            if (is_object($ar)){
                $res=$ar->attributes;
                $cont="昨日".$dt."数据\n";
                $cont.="充值总数：<<<".Yii::$app->formatter->asInteger(($res['recharge_total']+intval($res['agent_cash']==null?0:$res['agent_cash']))).">>>元\n";
                $cont.="客户端充值：【".$res['recharge_total']."】元".$res['recharge_num']."人，arpu:".Yii::$app->formatter->asDecimal($res['recharge_num']==0?0:$res['recharge_total']/$res['recharge_num'],1)."\n";
                $cont.="Agent：【".$res['agent_cash']."】元 人数".$res['agent_num']."人,arpu:".Yii::$app->formatter->asDecimal($res['agent_num']==0?0:$res['agent_cash']/$res['agent_num'],1)."\n";
                $cont.="注册人数IME：【".$res['reg_num']."】，注册活跃".$res['regact_num']."\n";
                $cont.="登录人数：".$res['login_num']."，活跃人数".$res['active_num']."\n";
                $cont.="最大在线：".$res['max_online']."，当前在线".$res['now_online']."\n";
                $cont.="时时乐总押注：【".round($res['ssl_bet']/10000)."】亿，总返奖".round($res['ssl_reward']/10000,2)."亿,净消耗【".round(($res['ssl_bet']-$res['ssl_reward'])/10000,2)."亿】\n"; 
                $cont.="水浒传玩家净入:【";
                $cont.=isset($res['slot_coin'])?round($res['slot_coin']/100000000,2)."亿】":"0】";
                $cont.="参与人次:【";
                $cont.=isset($res['slot_num'])?$res['slot_num']:"0";
                $cont.="】参与人数:【";
                $cont.=isset($res['slot_player'])?$res['slot_player']:"0";
                $cont.="】\n";
                $cont.="百人数据：";
                $cont.=isset($res['hundred_coin'])?"玩家净盈利【".round($res['hundred_coin']/100000000,2)."亿】":"【数据异常】";
                $cont.="参与人数:【";
                $cont.=isset($res['hundred_num'])?$res['hundred_num']:"0";
                $cont.="】坐庄人数:【";
                $cont.=isset($res['hundred_zhuang'])?$res['hundred_zhuang']:"0";
                $cont.="】\n";
                $cont.="百人总押注:【".round($res['hundred_totalbet']/100000000,2)."】亿 局数：".$res['hundred_betnum']." 平均押注：【".$res['hundred_betavg']."】万\n"; 
                $cont.="AgentOut[".Yii::$app->formatter->asInteger($res['agent_out']==""?0:$res['agent_out'])."]，IN[".Yii::$app->formatter->asInteger($res['agent_in']==""?0:$res['agent_in'])."]\n";
                $recentRecharge=GmOrderlist::getYesterdayRecharge($days);
                foreach ($recentRecharge as $K=>$V){
                    $cont.=$V['k'].$V['v']."\n";
                }
                $content=$cont;
            }else {
                $content="欢迎你，xxx。\n 今天天气不错";
            }
            Yii::$app->cache->set($keyword, $content,7200);
        }else {
            $content=$data;
        }
        return $content;
    }
    public  static function getSsl()
    {
        $keyword = 'ssl-ranksdx2';
        $data = Yii::$app->cache[$keyword];
        $allres = [];
        if ($data === false||count($data)==0) {
            $db=Yii::$app->db_readonly;
//             $sql='select t1.gid,t2.name,t1.reward,t1.playnum from rank_ssl_daily t1,gm_player_info t2 where t1.gid= t2.account_id order by t1.reward desc limit 20';

            $sql='call getSslWinner(:bgtm,:endtm)';//select t1.gid,t2.name,t2.power,round(sum(reward)/10000,0) as totalReward,count(*) as totalNum 
            $allres = $db->createCommand($sql)->bindValues([':bgtm'=>date('Y-m-d 00:00:00'),':endtm'=>date('Y-m-d 23:59:59')])->queryAll();
//             $allres = $db->createCommand($sql)->queryAll();
            Yii::$app->cache->set($keyword, $allres,600);
        }else {
            $allres=$data;
        }
        return $allres;
        
    }
    public  static function getRecentStable()
    {
        $keyword = 'recentStablessx';
        $data = Yii::$app->cache[$keyword];
        $allres = [];
        if ($data === false||count($data)==0) {
            $db=Yii::$app->db_readonly;
            $sql='call get_recentdata();';
           $res = $db->createCommand($sql)->queryAll();
            Yii::error("Select result : \r\n".print_r($res,true));
            foreach ($res as $v){
                foreach ($v as $k=>$val){
                    switch ($k){
                        case 'onlineNum':
                            $k="当前在线";
                            break;
                        case 'regIme':
                            $k="注册IME";
                            break;
                        case 'regActIme':
                            $k="注册活跃IME";
                            break;
                        case 'logUid':
                            $k="登录用户数";
                            break;
                        case 'rechargeNum':
                            $k="充值人数";
                            break;
                        case 'totalCash':
                            $k="客户端充值";
                            break;
                        case 'agentCash':
                            $k="后台Agent充值";
                            break;
                        case 'agentNum':
                            $k="后台Agent充值人数";
                            break;
                    }  
                    array_push($allres, ['k'=>$k,'v'=>$val]);
                }
            }
            $sql='select  t1.source,sum(fee*100)/100 as totalfee from  gm_orderlist t1,gm_account_info t2
    where t1.status=2 and date_format(t1.utime,"%Y-%m-%d")=date_format(Now(),"%Y-%m-%d")
    and t1.playerid=t2.gid   group by source';
            $res = $db->createCommand($sql)
            //          ->bindValues($params)
            ->queryAll();
            foreach ($res as $k=>$v)
            {
                array_push($allres, ['k'=>$v['source']."-支付方式充值金额:",'v'=>$v['totalfee']]);
            }
            $sql='select  t3.channel_name,count(distinct t2.ime) as totalreg from log_ime_register t2,gm_channel_info t3
    where date_format(t2.reg_time,"%Y-%m-%d")=date_format(Now(),"%Y-%m-%d")  and t2.reg_channel=t3.cid   group by channel_name';
            $res = $db->createCommand($sql)
            //          ->bindValues($params)
            ->queryAll();
            foreach ($res as $k=>$v)
                {
                    array_push($allres, ['k'=>$v['channel_name']."-渠道注册人数(ime):",'v'=>$v['totalreg']]);
                }
                //当天金币总变更数
//             $sql='select sum(t1.change_coin/10000) as allcoin  from log_coin_records t1 where date_format(t1.ctime,"%Y-%m-%d")>date_format(date_sub(Now(),interval 1 day),"%Y-%m-%d") ;';
//             $rest = $db->createCommand($sql)->queryScalar();
//             array_push($allres, ['k'=>"今日金币变更总数:",'v'=>Yii::$app->formatter->asDecimal($rest,2)."万"]);
//             $sql='select t1.change_type,t2.c_name,sum(t1.change_coin/10000) as allcoin  
//                 from log_coin_records t1,cfg_coin_changetype t2 
//                 where date_format(t1.ctime,"%Y-%m-%d")>date_format(date_sub(Now(),interval 1 day),"%Y-%m-%d") 
//                 and t1.change_type=t2.cid group by change_type order by allcoin';
// //             $sql='SELECT t2.c_name,sum(t1.change_coin) as allcoin 
// //                 FROM `log_coin_records`t1,`cfg_coin_changetype`t2  
// //                 WHERE date_format(t1.ctime,"%Y-%m-%d %H:%i") > date_format(date_sub(Now(),interval 60 MINUTE),"%Y-%m-%d %H:%i") and t1.change_type=t2.cid group by t2.c_name;';
//             $res = $db->createCommand($sql)
//             //          ->bindValues($params)
//             ->queryAll();
//             foreach ($res as $k=>$v)
//             {
//                 array_push($allres, ['k'=>"今日金币变更 ".$v['c_name'].":",'v'=> Yii::$app->formatter->asDecimal($v['allcoin'],2)."万"]);
//             }
            
            Yii::$app->cache->set($keyword, $allres,120);
        }else {
                $allres=$data;
            }
        return $allres;
    }
    public static  function getdailyRecharge($datatype)
    {
//         $orders = GmOrderlist::find()->with('product', 'account.channel','player')->all();
//         // no SQL executed
//         $product= $orders[0]->product;
//         // no SQL executed
//         $account = $orders[0]->account;
//         $od = GmOrderlist::find()->with('product', 'account','player')
//         $orders = GmOrderlist::find()->with('product', 'account.channels','player')
//         ->select(['date_format(utime,"%Y-%m-%d") as udate' ,'source','sum(fee) as totalfee'])
//         ->where(['=','status',self::ORDER_NOT_RECHARGED])
//         ->addGroupBy(['udate','source'])->all();
        
//         Yii::error(print_r($orders,true));
        switch ($datatype){
            case self::DATA_TYPE_RECHARGE:
                {
                    $query = (new Query())
                    ->select(['date_format(t1.utime,"%Y-%m-%d") as udate','t3.channel_name','t1.source','sum(t1.fee) as totalfee','count(distinct t1.playerid) as pnum','count(orderid) as num',
                        'sum(t1.fee)/count(distinct t1.playerid) as up','sum(t1.fee)/count(orderid) as avg'])
                    ->from(['gm_orderlist as t1','gm_account_info as t2','gm_channel_info t3'])
                    ->where('t1.status = 2 and t1.playerid = t2.gid and t1.fee>0 and t2.reg_channel=t3.cid')
                    ->groupBy(['udate','t2.reg_channel','t1.source'])
//                     ->orderBy(['udate'=>SORT_DESC,'t3.channel_name'=>SORT_ASC])
                    ;
                    $queryallchannel = (new Query())
                    ->select(['date_format(t1.utime,"%Y-%m-%d") as udate','CONCAT("所有渠道","")','t1.source','sum(t1.fee) as totalfee','count(distinct t1.playerid) as pnum','count(orderid) as num',
                        'sum(t1.fee)/count(distinct t1.playerid) as up','sum(t1.fee)/count(orderid) as avg'])
                    ->from(['gm_orderlist as t1','gm_account_info as t2' ])
                    ->where('t1.status = 2 and t1.playerid = t2.gid and t1.fee>0 ')
                    ->groupBy(['udate','t1.source'])
                    ->orderBy(['udate'=>SORT_DESC])
                    ;
                    $queryallchannelsource = (new Query())
                    ->select(['date_format(t1.utime,"%Y-%m-%d") as udate','CONCAT("所有渠道","")','CONCAT("所有支付","")','sum(t1.fee) as totalfee','count(distinct t1.playerid) as pnum','count(orderid) as num',
                        'sum(t1.fee)/count(distinct t1.playerid) as up','sum(t1.fee)/count(orderid) as avg'])
                        ->from(['gm_orderlist as t1','gm_account_info as t2', ])
                        ->where('t1.status = 2 and t1.playerid = t2.gid and t1.fee>0')
                        ->groupBy(['udate'])
                        ->orderBy(['udate'=>SORT_DESC])
                        ;
                    $query->union($queryallchannel);
                    $query->union($queryallchannelsource);
                    $query->orderBy(['udate'=>SORT_DESC,'channel_name'=>SORT_ASC,'source'=>SORT_ASC]);
                    
//                     $query->addOrderBy(['udate'=>SORT_DESC,'channel_name'=>SORT_ASC,'source'=>SORT_ASC]);
                    break;
                }
            case self::DATA_TYPE_USER:
                {
                    $query = (new Query())
                    ->select(['date_format(t2.reg_time,"%Y-%m-%d") as udate','t1.channel_name','count(distinct t2.gid) as totalreg','count(distinct t3.gid) as loginp','count(t3.gid) as loginnum'])
                    ->from(['gm_channel_info as t1','gm_account_info as t2','log_userrequst as t3'])
                    ->where(' t1.cid = t2.reg_channel and t2.gid = t3.gid')
                    ->groupBy(['udate','t1.channel_name'])
                    ->orderBy(['udate'=>SORT_DESC,'t1.channel_name'=>SORT_ASC])
                    ;
                    break;
                }   
            case self::DATA_TYPE_STAY2:
                {
                    $query = (new Query())
                    ->select(['date_format(t1.utime,"%Y-%m-%d") as udate','t2.reg_channel','t1.source','sum(t1.fee) as totalfee'])
                    ->from(['gm_orderlist as t1','gm_account_info as t2'])
                    ->where('t1.status = 2 and t1.playerid = t2.gid and t1.fee>0')
                    ->groupBy(['udate','t2.reg_channel','t1.source'])
                    ;
                    break;
                }
            case self::DATA_TYPE_STAY3:
                {
                    $query = (new Query())
                    ->select(['date_format(t1.utime,"%Y-%m-%d") as udate','t2.reg_channel','t1.source','sum(t1.fee) as totalfee'])
                    ->from(['gm_orderlist as t1','gm_account_info as t2'])
                    ->where('t1.status = 2 and t1.playerid = t2.gid and t1.fee>0')
                    ->groupBy(['udate','t2.reg_channel','t1.source'])
                    ;
                    break;
                }
            case self::DATA_TYPE_STAY7:
                {
                    $query = (new Query())
                    ->select(['date_format(t1.utime,"%Y-%m-%d") as udate','t2.reg_channel','t1.source','sum(t1.fee) as totalfee'])
                    ->from(['gm_orderlist as t1','gm_account_info as t2'])
                    ->where('t1.status = 2 and t1.playerid = t2.gid and t1.fee>0')
                    ->groupBy(['udate','t2.reg_channel','t1.source'])
                    ;
                    break;
                }
            case self::DATA_TYPE_STAYPAY:
                {
                    $query = (new Query())
                    ->select(['date_format(t1.utime,"%Y-%m-%d") as udate','t2.reg_channel','t1.source','sum(t1.fee) as totalfee'])
                    ->from(['gm_orderlist as t1','gm_account_info as t2'])
                    ->where('t1.status = 2 and t1.playerid = t2.gid and t1.fee>0')
                    ->groupBy(['udate','t2.reg_channel','t1.source'])
                    ;
                    break;
                }
            default:
                {
                    $query = (new Query())
                    ->select(['date_format(t1.utime,"%Y-%m-%d") as udate','t2.reg_channel','t1.source','sum(t1.fee) as totalfee'])
                    ->from(['gm_orderlist as t1','gm_account_info as t2'])
                    ->where('t1.status = 2 and t1.playerid = t2.gid and t1.fee>0')
                    ->groupBy(['udate','t2.reg_channel','t1.source'])
                    ;
                    break;
                }
                
        }
        
        
        
//         $dataProvider = new ActiveDataProvider([
//             'query' => $query,
// //             GmOrderlist::find()->with('product', 'account.channels','player')
// //         ->select(['date_format(utime,"%Y-%m-%d") as udate' ,'source','sum(fee) as totalfee'])
// //         ->where(['=','status',self::ORDER_NOT_RECHARGED])
// //         ->addGroupBy(['udate','source'])->all(),
//             'pagination' => [
//                 'pageSize' => 20,
//             ]
            
//         ]);
        return $query;
    }
    
    
    
    
    public function getProduct()
    {//一对一
        return $this->hasOne(CfgProducts::className(), ['product_id' => 'productid']);
    }
    public function getPlayer()
    {//一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'playerid']);
    }
    public function getAccount()
    {//一对一
        return $this->hasOne(GmAccountInfo::className(), ['gid' => 'playerid']);
    }
}
