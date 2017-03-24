<?php

namespace app\modules\zjhapi\controllers;
use Yii;
use app\components\ApiCheck;
use app\components\ApiErrorCode;
use app\models\GmMonthCard;
class CardsController extends \yii\web\Controller
{
 public $enableCsrfValidation = false;
    
    public function beforeAction($action){
        if (Yii::$app->getRequest()->userIP=="127.0.0.1" || Yii::$app->getRequest()->userIP=="115.238.55.114" ){
            return true;
        }
        if (parent::beforeAction($action)) {
            if ($this->tryAction($action->id)){
                return true;
            }
            else{
                $ck = new ApiCheck();
                $token=Yii::$app->getRequest()->getQueryParam('token');
                $ts=Yii::$app->getRequest()->getQueryParam('ts');
                $sign = Yii::$app->getRequest()->getQueryParam('sign');
                if ($token == ""||$ts == ""){
                    echo json_encode(ApiErrorCode::$invalidParam);
                    return false;
                }elseif (!$ck->checkToken($token, $ts,$sign,Yii::$app->request->queryString)){
                    echo json_encode(ApiErrorCode::$CheckFailed);
                    return false;
                }else {
                    return  true;
                }
    
            }
    
        } else {
            return false;
        }
    
    }
    function tryAction($aid)
    {//在白名单的action不需要校验签名
        $list=['index',
        ];
        foreach ($list as $id)
        {
            if ($id == $aid)
                return true;
        }
        return FALSE;
    }
    public function actionIndex()
    {
        return "";
    }
    public function actionCardCheck()
    {//检查玩家的周卡月卡情况
        $gid = Yii::$app->getRequest()->getQueryParam('gid');
        $arr = ApiErrorCode::$OK;
        $arr['info']=GmMonthCard::checkCardValid($gid);
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        return $arr;
    }
    public function actionCardGet()
    {//领取奖励
        $gid = Yii::$app->getRequest()->getQueryParam('gid');
        $arr = ApiErrorCode::$OK;
        $arr['info']=GmMonthCard::getCardReward($gid);
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        return $arr;
    }
    public function actionEggCheck()
    {//金蛋次数
        return "xxx";
    }
    public function actionEggGet()
    {//砸金蛋
        return "xxx";
    }
}
