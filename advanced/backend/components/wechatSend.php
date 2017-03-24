<?php
namespace app\components;
use Yii;
class wechatSend
{
    const SENDURL = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=";
    const TOKENURL = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?";
    const GETDEPARTDETAIL = "https://qyapi.weixin.qq.com/cgi-bin/user/list";
    const GETDEPARTSIMPLE = "https://qyapi.weixin.qq.com/cgi-bin/user/simplelist";
    
    static $TEXTtpl=[
        "touser"=>"huzhiwei",
        "msgtype"=>"text",
        "agentid"=>"3",
        "text"=>[
        "content"=>"XXX",
        ],
        "safe"=>"0"
    ];

    public function warningTowx($content)
    {
        $userlist = $this->getUserlist(5);
//         $userlist='huzhiwei';
        return $this->SendWxMsg($userlist, $content);
    }
    public function sendTowx($touser,$content)
    {
//         $userlist = $this->getUserlist(5);
                $userlist=$touser;
        return $this->SendWxMsg($userlist, $content);
    }
    
    public function SendWxMsg($userid,$content)
    {
        $DT = self::$TEXTtpl;
        $DT['touser']=$userid;
        $DT['text']['content']=$content;
        $sd = json_encode($DT,JSON_UNESCAPED_UNICODE);
        $url = self::SENDURL.$this->getToken();
        $res = $this->postClient($url, $sd);
        return json_decode($res);
    }
    
    public function getUserlist($departid)
    {
        $tk=$this->getToken();
        Yii::error("TOKEN : ".$tk);
        $token = 'access_token='.$tk;
        $dpt='&department_id='.$departid;
        $users=[];
        $url = self::GETDEPARTSIMPLE.'?'.$token.$dpt.'&fetch_child=FETCH_CHILD&status=1';
        //{"errcode":0,"errmsg":"ok","userlist":[{"userid":"huzhiwei","name":"胡志伟","department":[2,5]}]}
        $result=json_decode($this->getClient($url));
        if ($result->errcode===0){
            foreach ($result->userlist as $k=>$sig){
                $uid = $sig->userid;
//                 Yii::error("wxapi need send userid:".$uid,'wxpai');
//                 echo $uid;
                array_push($users, $uid);
            }
        }
        return join($users, '|');
    }
    
    function getToken()
    {
        $keyword="wxtoken";
        $tokenx="";
        $data=Yii::$app->cache[$keyword];
        if ($data === false||count($data)==0) {
            $url=self::TOKENURL."corpid=".Yii::$app->params['corpid']."&corpsecret=".Yii::$app->params['wxsecret'];
            $tes=$this->getClient($url);
//             Yii::error("Get token from Http client Success ".$tes,'wxapi');
            $tes=json_decode($tes);
            $tk=$tes->access_token;
            Yii::error("Get token from Http client Success ".$tk,'wxapi');
            Yii::$app->cache->set($keyword, $tk,7200);
            $tokenx=$tk;
        }else {
            $tokenx=$data;
        }
        return $tokenx;
    }
    function getClient($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);//捕抓异常
            return;
        }
        curl_close($ch);
        return $output;
    }
    
    function postClient($url,$post_data){//POST方法
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);//捕抓异常
            return false;
        }
        curl_close($ch);
        return $output;
    }
    
}
