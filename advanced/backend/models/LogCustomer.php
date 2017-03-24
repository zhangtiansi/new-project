<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_customer".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $point
 * @property integer $coin
 * @property integer $propid
 * @property integer $propnum
 * @property integer $card_g
 * @property integer $card_s
 * @property integer $card_c
 * @property integer $status
 * @property string $ctime
 * @property string $ops
 * @property string $desc
 */
class LogCustomer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid','desc'], 'required'],
            [['gid', 'point', 'coin', 'propid', 'propnum', 'card_g', 'card_s', 'card_c', 'status'], 'integer'],
            [['ctime'], 'safe'],
            [['ops'], 'string', 'max' => 22],
            [['desc'], 'string', 'max' => 50],
            [['coin'],'validateMoney','params' => ['min' => '0'],'skipOnEmpty' => false,'on'=>'recharge'],
            [['coin'],'validateAccess','params' => ['min' => '0'],'skipOnEmpty' => false,'on'=>'customer'],
            [['gid'],'validateUser','params' => ['min' => '0'],'skipOnEmpty' => false,'on'=>'customer'],
            [['gid'],'validateUser','params' => ['min' => '0'],'skipOnEmpty' => false,'on'=>'recharge'],
            [['card_g'],'validateCard','params' => ['max' => '5'],'skipOnEmpty' => false,'on'=>'recharge'],
            [['card_s'],'validateCard','params' => ['max' => '5'],'skipOnEmpty' => false,'on'=>'recharge'],
            [['card_c'],'validateCard','params' => ['max' => '5'],'skipOnEmpty' => false,'on'=>'recharge'],
        ];
    }
    public function scenarios()
    {
        return [
            'recharge' => ['gid', 'point', 'coin', 'propid', 'propnum', 'card_g', 'card_s', 'card_c', 'status','ctime','ops','desc'],
            'customer' => [ 'gid', 'point', 'coin', 'propid', 'propnum', 'card_g', 'card_s', 'card_c', 'status','ctime','ops','desc'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => '玩家id',
            'point' => '钻石数',
            'coin' => '金币数',
            'propid' => '道具id',
            'propnum' => '道具数量',
            'card_g' => 'VIP金卡',
            'card_s' => 'VIP银卡',
            'card_c' => 'VIP铜卡',
            'status' => '状态',
            'ctime' => '创建时间',
            'ops' => '操作员',
            'desc' => '描述',
        ];
    }
    public function validateUser($attribute, $params)
    {
        $value = $this->$attribute;
        $u = GmPlayerInfo::findOne($value);
        if (!is_object($u)){
            $this->addError($attribute,'玩家Uid不存在');
        } 
    }
    public function validateCard($attribute, $params)
    {
        $value = $this->$attribute;
        if ($value > $params['max']) {
            $this->addError($attribute, '赠送卡不能超过'. $params['max']);
        }
        $agent = AgentInfo::findOne(['account_id'=>Yii::$app->user->id]);
        if (!is_object($agent)){
            $this->addError($attribute,'您的帐号非法');
        } 
    }
    public function validateMoney($attribute, $params)
    {
        $value = $this->$attribute;
        if ($value < $params['min']) {
            $this->addError($attribute, '充值不能少于'. $params['min']);
        }
        $agent = AgentInfo::findOne(['account_id'=>Yii::$app->user->id]);
        if (!is_object($agent)){
            $this->addError($attribute,'您的帐号非法');
        }
        $money=$agent->money;
        if ($value > $money) {
            $this->addError($attribute, '您的余额不足，当前 '.$money);
        }
    }
    public function validateAccess($attribute, $params)
    {
        $value = $this->$attribute; 
        $u=User::findOne(Yii::$app->user->id);
        if (!$u->checkRole(User::ROLE_ADMIN)){
            $this->addError($attribute,'您无权操作，请联系运营'); 
        } 
//         $money=$agent->money;
//         if ($value > $money) {
//             $this->addError($attribute, '您的余额不足，当前 '.$money);
//         }
    }
    
    public static function  getAgentorders($opid)
    {
        $db = Yii::$app->db;
        $sql = "select sum(coin)/10000 as totalcoin,sum(point) as point,sum(card_g) as card_g,sum(card_s) as card_s,sum(card_c) as card_c,
            count(*) as num from log_customer where ops=:opid and status=2
            ";
        $res=[];
        $res = $db->createCommand($sql)
        ->bindValues([':opid'=>$opid])
        ->queryOne();
        return $res;
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert) {
                if ($this->scenario=="recharge"){//Agent号充值金币
                    $agent = AgentInfo::findOne(['account_id'=>Yii::$app->user->id]);
                    $agent->money = $agent->money-$this->coin;
                    if($agent->save()){
                        $this->coin=80000*$this->coin;
                    }else {
                        $this->coin=0;
                    }
                }
                if ($this->point=="") $this->point=0;
                if ($this->coin=="") $this->coin=0;
                if ($this->propid=="") $this->propid=0;
                if ($this->propid==1)$this->propid=7;
                if ($this->propid==2)$this->propid=8;
                if ($this->propid==3)$this->propid=9;
                if ($this->propid==4)$this->propid=21;
                if ($this->propnum=="") $this->propnum=0;
                if ($this->card_g=="") $this->card_g=0;
                if ($this->card_s=="") $this->card_s=0;
                if ($this->card_c=="") $this->card_c=0;
                
                $this->ops = Yii::$app->user->id;
                $this->ctime = date('Y-m-d H:i:s');
                $this->status=1;
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        $syslog = new SysOplogs();
        if ($this->getScenario() === 'recharge') {
            // FIXME: TODO: WIP, TBD
            $agent = AgentInfo::findOne(['account_id'=>Yii::$app->user->id]);
            $log = new LogAgent();
            $log->agentid=$agent->id;
            $log->agentuid=$agent->account_id;
            $log->keyword = 'recharge';
            $log->logcid = $this->id;
            $log->ctime=date('Y-m-d H:i:s');
            $log->save();
            $syslog->keyword= 'recharge';
            $syslog->logs = "Agent号".$agent->agent_name."充值 用户：".$this->gid." 金币".$this->coin." 钻石：".$this->point
            .'道具：'.$this->propid==0?"0":CfgProps::getNameByid($this->propid).'道具数量:'.$this->propnum.
            'VIP金卡:'.$this->card_g." VIP银卡:".$this->card_s." VIP铜卡:".$this->card_c
            ;
        }else if ($this->getScenario() === 'customer') {
            // FIXME: TODO: WIP, TBD
            $u = User::findOne(Yii::$app->user->id);
            $syslog->keyword= 'customer';
            $syslog->logs = "后台客服号".$u->userdisplay." 赠送用户：".$this->gid." 金币".$this->coin." 钻石：".$this->point
            .'道具：'.$this->propid==0?"0":CfgProps::getNameByid($this->propid).'道具数量:'.$this->propnum.
            'VIP金卡:'.$this->card_g." VIP银卡:".$this->card_s." VIP铜卡:".$this->card_c;
            $mail = new LogMail();
            $mail->gid=$this->gid;
            $mail->title="客服后台处理";
            $mail->content="您获得后台发放， ";
            if ($this->coin !=0 )
                $mail->content.=" 金币[".$this->coin."],";
            if ($this->point !=0 )
                $mail->content.=" 钻石[".$this->point."],";
            if ($this->propid !=0 )
                $mail->content.='['.CfgProps::getNameByid($this->propid).']X'.$this->propnum.",";
            if ($this->card_g !=0)
                $mail->content.='VIP金卡['.$this->card_g."],";
            if ($this->card_s !=0)
                $mail->content.=" VIP银卡[".$this->card_s."],";
            if ($this->card_c !=0)
                $mail->content.=" VIP铜卡[".$this->card_c."],";
            if ($this->desc !="")
                $mail->content.=" 处理说明[".$this->desc."]";
            $mail->from_id=0;
            $mail->status = 0;
            $mail->ctime = date('Y-m-d H:i:s');
            $mail->save();
        }
        $syslog->opid=Yii::$app->user->id;
        $syslog->cid = $this->id;
        $syslog->gid = $this->gid;
        $syslog->desc = $this->desc;
        $syslog->ctime = date('Y-m-d H:i:d');
        if(!$syslog->save())
        {
            Yii::error(print_r($syslog->getErrors(),true));
        }
        
    }
    
    public function getOpuser(){
        return $this->hasOne(User::className(), ['id' => 'ops']);
    }
    public function getGift()
    {//一对一
        return $this->hasOne(CfgProps::className(), ['id' => 'propid']);
    }
    public function getPlayer()
    {//一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'gid']);
    }
}
