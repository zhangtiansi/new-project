<?php

namespace app\modules\wxwap;
use Yii;
use app\components\weixin;
use app\models\GmWechatInfo;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\wxwap\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
    public function beforeAction($action)
    {
        if (parent::beforeAction($action))
        { 
            $session = Yii::$app->session;
            //unset(Yii::$app->session['ShUserId']);
//             unset($session['wechatGameid']);
            if ($session->get('wechatGameid') ==""||!isset($session['wechatGameid'])||$session->get('wechatsessionid') ==""||!isset($session['wechatsessionid'])){
                //在这里完成校验鉴权的过程
                $tool=new weixin("");
                 if (isset($_GET['code']) && isset($_GET['state']) && $_GET['state']=='user_access_base' )
                {//已经由授权跳回基本信息验证这里可以得到 code 作为票据
                    $urlAccess=$tool->getBaseAccessUrl($_GET['code']);
                    $res=$tool->getClient($urlAccess);
                    Yii::error('tiaoshi  ..  code: '.$_GET['code'].' state:'.$_GET['state'],'wechatwap');
                    $uinfo = GmWechatInfo::findOne(['openid'=>$res->openid]);
                    if (isset($res->openid) && is_object($uinfo)){//用户已经存在userinfo
                        Yii::error('user exsits uid:'.$uinfo->gid,'wechatwap');
                        $session->set('wechatGameid',$uinfo->gid);
                        $session->set('wechatsessionid',$res->openid);
                    }else{//用户第一次访问，需要授权拿到userinfo
                        $rurl=Yii::$app->getRequest()->getAbsoluteUrl();
                        Yii::error('user not exists , url:'.$rurl,'wechatwap');
                        $oauthbaseUrl=$tool->getoauthUrl($rurl,'snsapi_userinfo', 'user_access_info');
                        Yii::error('get user info , redirect url now is:'.$oauthbaseUrl);
                        Yii::$app->getResponse()->redirect($oauthbaseUrl);
                    }
                }elseif (isset($_GET['code']) && isset($_GET['state']) && $_GET['state']=='user_access_info' ){
                    //获取用户详细信息
                    $urlAccess=$tool->getBaseAccessUrl($_GET['code']);
                    $res=$tool->getClient($urlAccess);
                    $access_token=$res->access_token;
                    $openid=$res->openid;
                    Yii::error('get user info access token:'.$access_token.' openid:'.$openid,'wechatwap');
                    $session->set('wechatsessionid',$openid);
                    $wechatuserid=$tool->CreateOauthUserInfo($openid, $access_token);
                    Yii::error(print_r($wechatuserid,true),'wechatwap'); 
                    $session->set('wechatGameid',$wechatuserid);
//                     Yii::$app->session['ShUserId']=$tool->CreateOauthUserInfo($openid, $access_token);
//                     Yii::error('user create suc  ,now userid: '.Yii::$app->session['ShUserId']);
                }else{
                    //初始进入
                    $rurl=Yii::$app->getRequest()->getAbsoluteUrl();
                    Yii::error('now user no session,need check ,url now:'.$rurl,'wechatwap');
                    $oauthbaseUrl=$tool->getoauthUrl($rurl,'snsapi_base', 'user_access_base');
                    Yii::error('oauth base url:'.$oauthbaseUrl,'wechatwap');
                    Yii::$app->getResponse()->redirect($oauthbaseUrl);
                }  
 
            }
            return true;
          }
            else
                return false;
    }
}
