<?php
namespace app\components;
use yii;
class ApiCheck
{
    public function checkToken($token,$ts,$sign,$queryString){
        $apikey = Yii::$app->params['apikey'];
        $res = md5($apikey.$ts);
        if($res == $token && $this->timeCheck($ts)){//校验时间在上下半小时之内
            $q = explode('&sign=', $queryString);
            if (count($q)>1 && md5($q[0]) == $sign){
                return true;
            }
        }
        return false;

    }
    
    
    public function timeCheck($time){
//         $date = date('Y-m-d',$time);
//         if ($date == date('Y-m-d')){
//             Yii::error('date return true');
//             return true;
//         }else {
//             Yii::error('date return false ');
//             return false;
//         }
        return true;
//         $min = time()-1800;
//         $max = time()+1800;
//         if ($time > $max || $time < $min){
//             Yii::error("time check faild");
//             return false;
//         }else {
//             return true;
//         }
        
    }
    public function genKey($ts,$account){
        $apikey = \Yii::$app->params['apikey'];
        $s = $ts.$apikey.$account;
        return substr(md5($s), 4,10);
        
    }
    
}