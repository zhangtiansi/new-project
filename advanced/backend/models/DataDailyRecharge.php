<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_daily_recharge".
 *
 * @property integer $id
 * @property string $udate
 * @property string $channel
 * @property string $source
 * @property string $totalfee
 * @property integer $pnum
 * @property integer $ptime
 * @property string $up
 * @property string $avg
 */
class DataDailyRecharge extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_daily_recharge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['udate', 'channel', 'totalfee', 'pnum', 'ptime', 'up', 'avg'], 'required'],
            [['udate'], 'safe'],
            [['pnum', 'ptime','new_recharge'], 'integer'],
            [['channel', 'source', 'totalfee'], 'string', 'max' => 50],
            [['up', 'avg'], 'string', 'max' => 10]
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
            'source' => '支付方式',
            'totalfee' => '总金额',
            'pnum' => '充值人数',
            'ptime' => '充值人次',
            'up' => 'Up值',
            'avg' => '平均值',
            'new_recharge'=>'首充人数',
        ];
    }
    
    public static function getRechargeData()
    {
        $sql='select date_format(t1.udate,"%d") as udate,t1.totalfee,t2.Alipay,t3.sms,t4.unionpay,t5.yeepay,t6.appstore,t8.wxpay,t7.agent from
                (SELECT udate,totalfee FROM `data_daily_recharge` WHERE  channel="999" and source="所有支付") as t1
                left join 
                (SELECT udate,totalfee as Alipay FROM `data_daily_recharge` WHERE  channel="999" and source="Alipay") as t2
                on t1.udate=t2.udate
                left join
                (SELECT udate,totalfee as sms FROM `data_daily_recharge` WHERE  channel="999" and source="sms") as t3
                on t1.udate=t3.udate
                left join
                (SELECT udate,totalfee as unionpay FROM `data_daily_recharge` WHERE  channel="999" and source="unionpay") as t4
                on t1.udate=t4.udate
                left join
                (SELECT udate,totalfee as yeepay FROM `data_daily_recharge` WHERE  channel="999" and source="yeepay") as t5
                on t1.udate=t5.udate
                left join
                (SELECT udate,totalfee as appstore FROM `data_daily_recharge` WHERE  channel="999" and source="appstore") as t6
                on t1.udate=t6.udate
                left join
                (select date_format(ta.ctime,"%Y-%m-%d") as udate,round(sum(coin)/80000,0) as agent  FROM  log_customer ta,user tb  
                WHERE ta.coin>0 and ta.ops=tb.id and tb.role=3 and date_format(ta.ctime,"%Y-%m")=date_format(now(),"%Y-%m")
                group by  udate
                ) as t7
                on t1.udate=t7.udate 
                left join
                (SELECT udate,totalfee as wxpay FROM `data_daily_recharge` WHERE  channel="999" and source="wxpay") as t8
                on t1.udate=t8.udate
                where date_format(t1.udate,"%Y-%m")=date_format(now(),"%Y-%m") order by udate';
        $keyword = 'recentrechargedailymonth5';
        $data = Yii::$app->cache[$keyword];

        if ($data === false||count($data)==0) {
            $db=Yii::$app->db_readonly;
            $res = $db->createCommand($sql)
                ->queryAll();
            Yii::$app->cache->set($keyword, $res,3600);
        }else {
            $res=$data;
        }
        return $res;
    }
    public static function newGetRechargeData(){
        $db=Yii::$app->db_readonly;
        $sql = 'select date_format(a.udate,"%d") as udate,a.totalfee,a.source,b.agent from
                (SELECT udate,totalfee,source FROM `data_daily_recharge` WHERE  channel="999" and source="所有支付" or source="Alipay" or source="sms" or source="unionpay" or source="yeepay" or source="appstore") as a
                left join
                (select date_format(ta.ctime,"%Y-%m-%d") as udate,round(sum(coin)/80000,0) as agent  FROM  log_customer ta,user tb
                WHERE ta.coin>0 and ta.ops=tb.id and tb.role=3 and date_format(ta.ctime,"%Y-%m")=date_format(now(),"%Y-%m")
                group by  udate
                ) as b
                on a.udate=b.udate
                where date_format(a.udate,"%Y-%m")=date_format(now(),"%Y-%m") order by udate';
        $res = $db->createCommand($sql)
            ->queryAll();
        $result = array();
        $result1 = 0;
        $result2 = 0;
        $result3 = 0;
        $result4 = 0;
        $result5 = 0;
        $result6 = 0;
        $totalfee = 0;
        $agent = 0;
        foreach($res as $key=>$value){
            if($value['source'] == 'Alipay'){
                $result1+=$value['totalfee'];
            }elseif($value['source'] == 'sms'){
                $result2+=$value['totalfee'];
            }elseif($value['source'] == 'unionpay'){
                $result3+=$value['totalfee'];
            }elseif($value['source'] == 'yeepay'){
                $result4+=$value['totalfee'];
            }elseif($value['source'] == 'appstore'){
                $result5+=$value['totalfee'];
            }elseif($value['source'] == 'wxpay'){
                $result6+=$value['totalfee'];
            }elseif(trim($value['source']) == '所有支付'){
                $totalfee+=$value['totalfee'];
            }


            $agent +=$value['agent'];
        }
        $result['totalfee'] = Yii::$app->formatter->asInteger($totalfee);
        $result['Alipay'] = $result1;
        $result['sms'] = $result2;
        $result['unionpay'] = $result3;
        $result['yeepay'] = $result4;
        $result['appstore'] = $result5;
        $result['wxpay'] = $result6;
        $result['agent'] = Yii::$app->formatter->asInteger($agent);
        $result['num'] = Yii::$app->formatter->asInteger($totalfee+$agent);
        return array(0=>$result,1=>$res);
    }
    public static function getAgentRecharge()
    {
        $sql='select date_format(t1.ctime,"%d") as udate,round(sum(coin)/80000,0) as totalfee  FROM  log_customer t1,user t2  WHERE t1.coin>0 and t1.ops=t2.id and t2.role=3 and date_format(t1.ctime,"%Y-%m")=date_format(now(),"%Y-%m")
            group by udate';
        $keyword = 'agentRechargebydaily4';
        $data = Yii::$app->cache[$keyword];
        if ($data === false||count($data)==0) {
            $db=Yii::$app->db_readonly;
            $res = $db->createCommand($sql)
            ->queryAll();
            Yii::$app->cache->set($keyword, $res,3600);
        }else {
            $res=$data;
        }
        return $res;
    }
    public static function getLastMonthRechargeData()
    {
        $sql='select date_format(t1.udate,"%d") as udate,t1.totalfee,t2.Alipay,t3.sms,t4.unionpay,t5.yeepay,t6.appstore,t7.agent,t8.wxpay from
                (SELECT udate,totalfee FROM `data_daily_recharge` WHERE  channel="999" and source="所有支付") as t1
                left join
                (SELECT udate,totalfee as Alipay FROM `data_daily_recharge` WHERE  channel="999" and source="Alipay") as t2
                on t1.udate=t2.udate
                left join
                (SELECT udate,totalfee as sms FROM `data_daily_recharge` WHERE  channel="999" and source="sms") as t3
                on t1.udate=t3.udate
                left join
                (SELECT udate,totalfee as unionpay FROM `data_daily_recharge` WHERE  channel="999" and source="unionpay") as t4
                on t1.udate=t4.udate
                left join
                (SELECT udate,totalfee as yeepay FROM `data_daily_recharge` WHERE  channel="999" and source="yeepay") as t5
                on t1.udate=t5.udate
                left join
                (SELECT udate,totalfee as appstore FROM `data_daily_recharge` WHERE  channel="999" and source="appstore") as t6
                on t1.udate=t6.udate
                left join
                (select date_format(ta.ctime,"%Y-%m-%d") as udate,round(sum(coin)/80000,0) as agent  FROM  log_customer ta,user tb
                WHERE ta.coin>0 and ta.ops=tb.id and tb.role=3 and date_format(ta.ctime,"%Y-%m")=date_format(date_sub(Now(),INTERVAL 1 Month),"%Y-%m")
                group by  udate
                ) as t7
                on t1.udate=t7.udate
                left join
                (SELECT udate,totalfee as wxpay FROM `data_daily_recharge` WHERE  channel="999" and source="wxpay") as t8
                on t1.udate=t8.udate
                where date_format(t1.udate,"%Y-%m")=date_format(date_sub(Now(),INTERVAL 1 Month),"%Y-%m") order by udate';
        $keyword = 'Lastmonthrecharge4';
        $data = Yii::$app->cache[$keyword];
    
        if ($data === false||count($data)==0) {
            $db=Yii::$app->db_readonly;
            $res = $db->createCommand($sql)
            ->queryAll();
            Yii::$app->cache->set($keyword, $res,3600);
        }else {
            $res=$data;
        }
        return $res;
    }

    public function newGetLastMonthRechargeData(){
        $sql = 'select date_format(a.udate,"%d") as udate,a.totalfee,a.source,b.agent from
                (SELECT udate,totalfee,source FROM `data_daily_recharge` WHERE  channel="999" and source="所有支付" or source="Alipay" or source="sms" or source="unionpay" or source="yeepay" or source="appstore") as a
                left join
                (select date_format(ta.ctime,"%Y-%m-%d") as udate,round(sum(coin)/80000,0) as agent  FROM  log_customer ta,user tb
                WHERE ta.coin>0 and ta.ops=tb.id and tb.role=3 and date_format(ta.ctime,"%Y-%m")=date_format(date_sub(Now(),INTERVAL 1 Month),"%Y-%m")
                group by  udate
                ) as b
                on a.udate=b.udate
                where date_format(a.udate,"%Y-%m")=date_format(date_sub(Now(),INTERVAL 1 Month),"%Y-%m") order by udate';
        $db=Yii::$app->db_readonly;
        $res = $db->createCommand($sql)
            ->queryAll();
        $result = array();
        $result1 = 0;
        $result2 = 0;
        $result3 = 0;
        $result4 = 0;
        $result5 = 0;
        $result6 = 0;
        $totalfee = 0;
        $agent = 0;
        foreach($res as $key=>$value){
            if($value['source'] == 'Alipay'){
                $result1+=$value['totalfee'];
            }elseif($value['source'] == 'sms'){
                $result2+=$value['totalfee'];
            }elseif($value['source'] == 'unionpay'){
                $result3+=$value['totalfee'];
            }elseif($value['source'] == 'yeepay'){
                $result4+=$value['totalfee'];
            }elseif($value['source'] == 'appstore'){
                $result5+=$value['totalfee'];
            }elseif($value['source'] == 'wxpay'){
                $result6+=$value['totalfee'];
            }elseif(trim($value['source']) == '所有支付'){
                $totalfee+=$value['totalfee'];
            }


            $agent +=$value['agent'];
        }
        $result['totalfee'] = Yii::$app->formatter->asInteger($totalfee);
        $result['Alipay'] = $result1;
        $result['sms'] = $result2;
        $result['unionpay'] = $result3;
        $result['yeepay'] = $result4;
        $result['appstore'] = $result5;
        $result['wxpay'] = $result6;
        $result['agent'] = Yii::$app->formatter->asInteger($agent);
        $result['num'] = Yii::$app->formatter->asInteger($totalfee+$agent);
        return array(0=>$result,1=>$res);
    }
}
