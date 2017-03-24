<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_month_card".
 *
 * @property integer $gid
 * @property integer $firstbg_tm
 * @property integer $buy_tm
 * @property string $lastbuy_tm
 * @property string $lastget_tm
 */
class GmMonthCard extends \yii\db\ActiveRecord
{
    const PRODUCT_CARD_WEEK = "card_week";
    const PRODUCT_CARD_MONTH = "card_month";
    const CARD_TIME_WEEK = 604800;
    const CARD_TIME_MONTH = 2592000;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_month_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'firstbg_tm', 'buy_tm', 'lastbuy_tm'], 'required'],
            [['gid', 'firstbg_tm', 'buy_tm'], 'integer'],
            [['lastbuy_tm', 'lastget_tm'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'firstbg_tm' => '起始时间',//起点时间
            'buy_tm' => '购买持续时间',//持续的时间
            'lastbuy_tm' => '最后一次购买时间',//只是做记录用
            'lastget_tm' => '最后一次领取奖励时间',
        ];
    }
    
    public static function AddCard($gid,$cardType,$order)
    {
        $logbuy = new LogBuycards();//记录日志
        $logbuy->buy_orderid=$order;
        $logbuy->gid=$gid;
        $logbuy->buy_tm=date('Y-m-d H:i:s');
        $logbuy->cardtype=$cardType;
        if ($logbuy->save())
        {
            Yii::error("save buy card success order id: ".$order,'buycard'); 
        }else {
            Yii::error("save buy card log failed ".print_r($logbuy->getErrors(),true),'buycard');
        }
//         Yii::error("buy card type ".$cardType,'buycard');
        if ($cardType==GmMonthCard::PRODUCT_CARD_WEEK)
        {
            $nowts= time();//当前时间戳
            $info = GmWeekCard::findOne($gid);
            if (is_object($info)&& ($info->firstbg_tm +$info->buy_tm) >$nowts)
            {//以前买过并且还在有效期，需要续时间 
                $info->buy_tm += GmMonthCard::CARD_TIME_WEEK;
                $info->lastbuy_tm = date('Y-m-d H:i:s'); 
                if ($info->save())
                {
                    Yii::error("week CARD time add success ".$order,'buycard');
                    return true;
                }else {
                    Yii::error("week CARD time add failed  ".print_r($info->getErrors(),true),'buycard');
                    return false;
                }
            }else {//没买过或者已经过期
                if (!is_object($info))
                    $info = new GmWeekCard();
                $info->gid=$gid;
                $info->firstbg_tm = $nowts;
                $info->buy_tm = GmMonthCard::CARD_TIME_WEEK;
                $info->lastbuy_tm = date('Y-m-d H:i:s'); 
                if ($info->save())
                { 
                    Yii::error("week CARD time add success ".$order,'buycard');
                    return true;
                }else {
                    Yii::error("week CARD time add failed  ".print_r($info->getErrors(),true),'buycard');
                    return false;
                }
            }
        }elseif ($cardType==GmMonthCard::PRODUCT_CARD_MONTH)
        {
            Yii::error("month CARD type ");
            $nowts= time();//当前时间戳
            $info = GmMonthCard::findOne($gid);
            if (is_object($info)&& ($info->firstbg_tm +$info->buy_tm) >$nowts)
            {//以前买过并且还在有效期，需要续时间
                $info->buy_tm += GmMonthCard::CARD_TIME_MONTH;
                $info->lastbuy_tm = date('Y-m-d H:i:s');
                if ($info->save())
                {
                    Yii::error("month CARD time add success ".$order,'buycard');
                    return true;
                }else {
                    Yii::error("month CARD time add failed  ".print_r($info->getErrors(),true),'buycard');
                    return false;
                }
            }else {//没买过或者已经过期
                if (!is_object($info))
                    $info = new GmMonthCard();
                $info->gid=$gid;
                $info->firstbg_tm = $nowts;
                $info->buy_tm = GmMonthCard::CARD_TIME_MONTH;
                $info->lastbuy_tm = date('Y-m-d H:i:s');
                if ($info->save())
                {
                    Yii::error("month CARD time add success ".$order,'buycard');
                    return true;
                }else {
                    Yii::error("month CARD time add failed  ".print_r($info->getErrors(),true),'buycard');
                    return false;
                }
            }
        }
    }
    public static function AddFirstBuy($gid,$cardType)
    {
        if ($cardType==GmMonthCard::PRODUCT_CARD_MONTH)
        {
            $act = new LogActrewards();
            $act->gid=$gid;
            $act->point=0;
            $act->coin=600000;
            $act->propid=21;//绿喇叭
            $act->propnum=2;//兑换券
            $act->card_g=0;
            $act->card_s=0;
            $act->card_c=0;
            $act->status=1;
            $act->ctime=date('Y-m-d H:i:s');
            $act->change_type=strval(34);
            $act->desc="月卡初次购买";
        }elseif ($cardType==GmMonthCard::PRODUCT_CARD_WEEK)
        {
            $act = new LogActrewards();
            $act->gid=$gid;
            $act->point=0;
            $act->coin=200000;
            $act->propid=21;//绿喇叭
            $act->propnum=1;//兑换券
            $act->card_g=0;
            $act->card_s=0;
            $act->card_c=0;
            $act->status=1;
            $act->ctime=date('Y-m-d H:i:s');
            $act->change_type=strval(35);
            $act->desc="周卡初次购买";
        }
    }
    public static function checkCardValid($gid)
    {
        $monthCardTime = 0;//月卡剩余持续时间
        $weekCardTime = 0;//周卡剩余持续
        $canGetMonthToday = 0;//今天是否能领取月卡奖励
        $canGetWeekToday = 0; //今天是否能领取周卡奖励
        $mc = GmMonthCard::findOne($gid);
        $wc = GmWeekCard::findOne($gid);
        $nowts= time();//当前时间戳
        if (is_object($mc) && ($mc->firstbg_tm +$mc->buy_tm) >$nowts)
        {//月卡在有效期之内
            $monthCardTime = $mc->firstbg_tm +$mc->buy_tm - $nowts;
            if (date('Y-m-d',strtotime($mc->lastget_tm)) < date('Y-m-d'))//今天没有领取奖励
                $canGetMonthToday=1;
        }
        if (is_object($wc) && ($wc->firstbg_tm +$wc->buy_tm) >$nowts)
        {//周卡卡在有效期之内
            $weekCardTime = $wc->firstbg_tm +$wc->buy_tm - $nowts;
            if (date('Y-m-d',strtotime($wc->lastget_tm)) < date('Y-m-d'))//今天没有领取奖励
                $canGetWeekToday=1;
        }
        return ['monthCardTime'=>$monthCardTime,'weekCardTime'=>$weekCardTime,'canGetMonthToday'=>$canGetMonthToday,'canGetWeekToday'=>$canGetWeekToday];
    }
    
    public static function getCardReward($gid)
    { 
        $monthreward="恭喜你获得月卡奖励40000金币,绿喇叭2个";
        $weekreward="恭喜你获得周卡奖励30000金币,绿喇叭1个";
        $isGetMonthToday = 0;//今天是否 领取月卡奖励成功
        $isGetWeekToday = 0; //今天是否 领取周卡奖励成功
        $mc = GmMonthCard::findOne($gid);
        $wc = GmWeekCard::findOne($gid);
        $nowts= time();//当前时间戳
        if (is_object($mc) && ($mc->firstbg_tm +$mc->buy_tm) >$nowts && date('Y-m-d',strtotime($mc->lastget_tm)) != date('Y-m-d'))
        {//月卡在有效期之内并且今天未领取
            
             $act = new LogActrewards();
             $act->gid=$gid;
             $act->point=0;
             $act->coin=40000;
             $act->propid=21;//绿喇叭
             $act->propnum=2;//数量
             $act->card_g=0;
             $act->card_s=0;
             $act->card_c=0;
             $act->status=1;
             $act->ctime=date('Y-m-d H:i:s');
             $act->change_type=strval(36);
             $act->desc="月卡奖励"; 
            Yii::error("mc starttime ".$mc->firstbg_tm);
             if (date('Y-m-d',$mc->firstbg_tm)==date('Y-m-d')){ 
                 $act->coin=600000;
                 $monthreward="恭喜你获得月卡首次购买奖励60万金币,绿喇叭2个";
                 $act->desc="月卡首次60万奖励";
             }
             $mc->lastget_tm=date('Y-m-d H:i:s');
             if ($mc->save()){
                 if ($act->save())
                 {
                     $isGetMonthToday=1;
                 }
             }
        }
        if (is_object($wc) && ($wc->firstbg_tm +$wc->buy_tm) >$nowts && date('Y-m-d',strtotime($wc->lastget_tm)) != date('Y-m-d'))
        {//周卡卡在有效期之内并且未领取
            $act = new LogActrewards();
            $act->gid=$gid;
            $act->point=0;
            $act->coin=30000;
            $act->propid=21;//绿喇叭
            $act->propnum=1;//兑换券
            $act->card_g=0;
            $act->card_s=0;
            $act->card_c=0;
            $act->status=1;
            $act->ctime=date('Y-m-d H:i:s');
            $act->change_type=strval(35);
            $act->desc="周卡奖励"; 
            Yii::error("starttime ".$wc->firstbg_tm);
            if (date('Y-m-d',$wc->firstbg_tm)==date('Y-m-d')){
                $act->coin=200000;
                $weekreward="恭喜你获得周卡首次购买奖励20万金币,绿喇叭2个";
                $act->desc="周卡首次20万奖励";
            }
            $wc->lastget_tm=date('Y-m-d H:i:s');
            if ($wc->save()){
                if ($act->save())
                {
                    $isGetWeekToday=1;
                }
            }
        }
        return ['isGetMonthToday'=>$isGetMonthToday,'isGetWeekToday'=>$isGetWeekToday,'monthreward'=>$monthreward,'weekreward'=>$weekreward];
    }
}
