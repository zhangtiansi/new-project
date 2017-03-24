<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_player_info".
 *
 * @property integer $account_id
 * @property integer $partner_id
 * @property string $name
 * @property string $account
 * @property integer $sex
 * @property integer $point
 * @property integer $money
 * @property integer $last_login
 * @property integer $level
 * @property integer $power
 * @property integer $charm
 * @property integer $exploit
 * @property integer $create_time
 * @property integer $status
 * @property string $icon
 * @property integer $point_box
 * @property string $point_pwd
 * @property integer $max_win
 * @property string $sign
 * @property string $tel
 * @property string $avatar64
 */
class GmPlayerInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_player_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id'], 'required'],
            [['account_id', 'partner_id', 'sex', 'point', 'money', 'last_login', 'level', 'power', 'charm', 'exploit', 'create_time', 'status', 'point_box', 'max_win'], 'integer'],
            [['avatar64'], 'string'],
            [['name'], 'string', 'max' => 256],
            [['account', 'icon', 'sign', 'tel'], 'string', 'max' => 50],
            [['point_pwd'], 'string', 'max' => 20],
            [['money','point','point_box'],'validateMoney','params' => ['min' => '0'],'skipOnEmpty' => true,'on'=>'modify'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_id' => '玩家UID',
            'partner_id' => 'Partner ID',
            'name' => '昵称',
            'account' => '帐号',
            'sex' => '性别',
            'point' => '钻石数',
            'money' => '金币',
            'last_login' => '最后登录',
            'level' => '等级',
            'power' => 'VIP等级',
            'charm' => '魅力值',
            'exploit' => 'Exploit',
            'create_time' => '创建时间',
            'status' => '状态/设置1不上榜',
            'icon' => 'Icon',
            'point_box' => '保险箱金币',
            'point_pwd' => 'Point Pwd',
            'max_win' => 'Max Win',
            'sign' => '签名',
            'tel' => '联系方式',
            'avatar64' => 'Avatar64',
        ];
    }
    public function validateMoney($attribute, $params)
    {
        $value = $this->$attribute;
        if ($value < $params['min']) {
            $this->addError($attribute, '不能小于'. $params['min']);
        }
    }
    
    public function scenarios()
    {
        return [
            'modify' => ['account_id', 'name', 'sex', 'point', 'money', 'charm', 'point_box','status', 'sign', 'tel' ],
        ];
    }
    
    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        $syslog = new SysOplogs();
        if ($this->getScenario() === 'modify') {
            // FIXME: TODO: WIP, TBD
            $u = User::findOne(Yii::$app->user->id);
            $syslog->keyword= 'modify';
            $syslog->logs = "后台客服号".$u->userdisplay."修改用户信息:".$this->account_id." name:".$this->name." 金币:".$this->money." 钻石:".$this->point." 保险箱 ".$this->point_box;
        }
        $syslog->opid=Yii::$app->user->id;
        $syslog->cid =0;
        $syslog->gid = $this->account_id;
        $syslog->desc = $syslog->logs;
        $syslog->ctime = date('Y-m-d H:i:d');
        if(!$syslog->save())
        {
            Yii::error(print_r($syslog->getErrors(),true));
        }
    
    }
    
    public function getOrders()
    {
        // 产品和订单通过 GmOrderlist.playerid -> account_id 关联建立一对多关系
        return $this->hasMany(GmOrderlist::className(), ['playerid' => 'account_id']);
    }
    public static function getOrderinfo($gid)
    {//获取玩家的所有订单信息
        $db = Yii::$app->db;
        $param = [':gid'=>$gid];
        $sql="select count(*) as num,IFNULL(sum(fee),0) as cash from gm_orderlist where playerid=:gid and status=2";
        $res = $db->createCommand($sql)
            ->bindValues($param)
            ->queryOne();
        return $res;
    }
    public static function getRechargeInfo($gid)
    {//获取玩家的所有Agent 仙草订单信息
        $db = Yii::$app->db;
        $param = [':gid'=>$gid];
        $sql="call getPlayerRechargeSummary(:gid) ";
        $res = $db->createCommand($sql)
        ->bindValues($param)
        ->queryOne();
        return $res;
    }
    
    public static function getAgentOrderinfo($gid)
    {//获取玩家的所有Agent 仙草订单信息
        $db = Yii::$app->db;
        $param = [':gid'=>$gid];
        $sql="select round(IFNULL(sum(gift_num),0)/8,0) as cash from log_gift where from_uid  in (120121, 129046, 33333,11111) and to_uid=:gid";
        $res = $db->createCommand($sql)
        ->bindValues($param)
        ->queryOne();
        return $res;
    }
    public static function getAgentOrderBackinfo($gid)
    {//获取玩家的所有Agent 仙草订单信息回收
        $db = Yii::$app->db;
        $param = [':gid'=>$gid];
        $sql="select round(IFNULL(sum(gift_num),0)/8.5,0) as cash from log_gift where from_uid=:gid and to_uid  in (120121, 129046, 33333,11111)";
        $res = $db->createCommand($sql)
        ->bindValues($param)
        ->queryOne();
        return $res;
    }
    public static function getAgentBackendinfo($gid)
    {//获取玩家的所有Agent 后台订单信息
        $db = Yii::$app->db;
        $param = [':gid'=>$gid];
        $sql="select count(*) as num,IFNULL(sum(coin),0)/80000 as cash from log_customer where ops=8 and gid=:gid and status=2 and coin>0";
        $res = $db->createCommand($sql)
        ->bindValues($param)
        ->queryOne();
        return $res;
    }
    public static function getLoginfo($gid)
    {//获取玩家的所有订单信息
        $db = Yii::$app->db;
        $param = [':gid'=>$gid];
        $sql="select osver,appver,lineNo,dev_id,channel,ctime,request_ip,city,isp from log_userrequst where gid=:gid order by ctime desc limit 5";
        $res = $db->createCommand($sql)
        ->bindValues($param)
        ->queryAll();
        return $res;
    }
    
    public function getPlayerFlag()
    {//一对一
        return $this->hasOne(GmPlayerFlag::className(), ['account_id' => 'account_id']);
    }
    
    public static function getNickbyId($gid)
    {
        $o=GmPlayerInfo::findOne($gid);
        if (is_object($o)){
            return GmPlayerInfo::findOne($gid)->name;
        }else {
            return "";
        }
    }
    
    public function getPlayerAccount()
    {//一对一
        return $this->hasOne(GmAccountInfo::className(), ['gid' => 'account_id']);
    }
}
