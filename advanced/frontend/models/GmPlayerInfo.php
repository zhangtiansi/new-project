<?php

namespace app\models;

use Yii;
use app\components\ApiErrorCode;

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
            [['name', 'point_pwd'], 'string', 'max' => 20],
            [['account', 'icon', 'sign'], 'string', 'max' => 50],
            [['avatar64'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_id' => 'Account ID',
            'partner_id' => 'Partner ID',
            'name' => 'Name',
            'account' => 'Account',
            'sex' => 'Sex',
            'point' => '钻石',
            'money' => '金币',
            'last_login' => 'Last Login',
            'level' => 'Level等级',
            'power' => 'vip等级',
            'charm' => 'Charm',
            'exploit' => 'Exploit',
            'create_time' => 'Create Time',
            'status' => 'Status',
            'icon' => 'Icon',
            'point_box' => 'Point Box',
            'point_pwd' => 'Point Pwd',
            'max_win' => 'Max Win',
            'sign' => 'Sign',
        ];
    }
    
    public function getRichRank()
    {
        $keyword = "richrank2";
        $data = Yii::$app->cache[$keyword];
        if ($data === false||count($data)==0) {
            $db = \yii::$app->db;
            $lists = $db->createCommand('SELECT account_id,name,money as value,icon,power FROM gm_player_info  where status!=1 order by money desc limit 15')
            ->queryAll();
            Yii::$app->cache->set($keyword, $lists,3600);
        }else {
            $lists = $data;
        }
        if (count($lists) >0)
        {
            $arr=[];
            foreach ($lists as $k=>$v)
            {
                $arr[$k]['rank']=strval($k+1);
                $arr[$k]['gid']=strval($v['account_id']);
                $arr[$k]['nick']=strval($v['name']);
                $arr[$k]['avatar']=strval($v['icon']);
                $arr[$k]['viplevel']=strval($v['power']);
                $arr[$k]['value']=strval($v['value']);
            }
            $res = ApiErrorCode::$OK;
            $res['info']=$arr;
            return $res;
        }else {
            return ApiErrorCode::$RuleError;
        }
        
    }
    public function getSslRank()
    {
        $keyword = "sslrank2";
        $data = Yii::$app->cache[$keyword];
        if ($data === false||count($data)==0) {
            $db = \yii::$app->db;
            $lists = $db->createCommand('SELECT account_id,name,t2.reward as value,icon,power FROM gm_player_info t1,rank_ssl_daily t2  
                where t1.status!=1 and t1.account_id=t2.gid order by value desc limit 15')
            ->queryAll();
            Yii::$app->cache->set($keyword, $lists,60);
        }else {
            $lists = $data;
        }
        if (count($lists) >0)
        {
            $arr=[];
            foreach ($lists as $k=>$v)
            {
                $arr[$k]['rank']=strval($k+1);
                $arr[$k]['gid']=strval($v['account_id']);
                $arr[$k]['nick']=strval($v['name']);
                $arr[$k]['avatar']=strval($v['icon']);
                $arr[$k]['viplevel']=strval($v['power']);
                $arr[$k]['value']=strval($v['value']);
            }
            $res = ApiErrorCode::$OK;
            $res['info']=$arr;
            return $res;
        }else {
            return ApiErrorCode::$RuleError;
        }
    
    }
    
    public function getCharmRank()
    {
        
        $keyword = "charmrank1";
        $data = Yii::$app->cache[$keyword];
        if ($data === false||count($data)==0) {
            $db = \yii::$app->db;
            $lists = $db->createCommand('SELECT account_id,name,charm as value,icon,power FROM gm_player_info where status!=1 order by charm desc limit 15')
            ->queryAll();
            Yii::$app->cache->set($keyword, $lists,3600);
        }else {
            $lists = $data;
        }
        
        if (count($lists) >0)
        {
            $arr=[];
            foreach ($lists as $k=>$v)
            {
                $arr[$k]['rank']=strval($k+1);
                $arr[$k]['gid']=strval($v['account_id']);
                $arr[$k]['nick']=strval($v['name']);
                $arr[$k]['avatar']=strval($v['icon']);
                $arr[$k]['viplevel']=strval($v['power']);
                $arr[$k]['value']=strval($v['value']);
            }
            $res = ApiErrorCode::$OK;
            $res['info']=$arr;
            return $res;
        }else {
            return ApiErrorCode::$RuleError;
        }
        
    }
    
    public function getMaxRank()
    {
        
        $keyword = "max_yesterday_rank";
        $data = Yii::$app->cache[$keyword];
        if ($data === false||count($data)==0) {
            $db = \yii::$app->db;
            $lists = $db->createCommand('SELECT t1.gid as account_id,t1.coin as mx,t2.name,t2.power,t2.icon FROM `log_max_gamechange`t1,gm_player_info t2 WHERE t1.ctime=date_format(date_sub(now(),Interval 1 day),"%Y-%m-%d") and t1.gid=t2.account_id and t2.status!=1 group by t1.gid order by mx desc limit 15')
            ->queryAll();
            Yii::$app->cache->set($keyword, $lists,7200);
        }else {
            $lists = $data;
        }
        if (count($lists) >0)
        {
            $arr=[];
            foreach ($lists as $k=>$v)
            {
                $arr[$k]['rank']=strval($k+1);
                $arr[$k]['gid']=strval($v['account_id']);
                $arr[$k]['nick']=strval($v['name']);
                $arr[$k]['avatar']=strval($v['icon']);
                $arr[$k]['viplevel']=strval($v['power']);
                $arr[$k]['value']=strval($v['mx']);
            }
            $res = ApiErrorCode::$OK;
            $res['info']=$arr;
            return $res;
        }else {
            $db = \yii::$app->db;
            $lists = $db->createCommand('SELECT t1.uid as account_id,max(t1.change_coin) as mx,t2.name,t2.power,t2.icon FROM `log_coin_records`t1,gm_player_info t2 WHERE t1.change_type=1 and t1.uid=t2.account_id  and t2.status!=1 group by t1.uid order by mx desc limit 1')
            ->queryAll();
            $arr=[];
            foreach ($lists as $k=>$v)
            {
                $arr[$k]['rank']=strval($k+1);
                $arr[$k]['gid']=strval($v['account_id']);
                $arr[$k]['nick']=strval($v['name']);
                $arr[$k]['avatar']=strval($v['icon']);
                $arr[$k]['viplevel']=strval($v['power']);
                $arr[$k]['value']=strval($v['mx']);
            }
            $res = ApiErrorCode::$OK;
            $res['info']=$arr;
            return $res;
        }
    
    }
    
}
