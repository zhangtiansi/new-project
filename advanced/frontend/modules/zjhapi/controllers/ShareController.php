<?php

namespace app\modules\zjhapi\controllers;

use yii;
use yii\web\Controller;
use app\components\ApiCheck;
use app\components\ApiErrorCode;
use app\models\GmAccountInfo;
use app\models\AlipayNoticeLogs;
use yii\grid\DataColumn;
use app\models\GmOrderlist;
use app\models\GmPlayerInfo;
use app\models\GmActivity;
use app\models\GmAnnouncement;
use app\models\GmVersion;
use app\models\LogYeepayNotice;
use app\models\CfgProducts;
use yii\web\NotFoundHttpException;
use app\models\LogSyserror;
use app\models\LogLlpayNotice;
use app\models\IosPaylogs;
use app\models\ReceiptData;
use app\models\LogUserlogin;
use app\models\LogUserrequst;
use app\models\CfgServerlist;
use app\models\GmChannelInfo;
use app\models\Ttszp;
use app\components\yeepay;
use app\models\CfgTree;
use app\models\LogTree;
use app\models\LogBlacklist;
use app\components\HttpClient;
use yii\web\Response;
use app\models\LogImeRegister;
use app\components\WxPayNotify;
use app\models\LogWxpay;
use app\modules\agent\controllers\OrderController;
use app\components\secureUtil;
use app\models\DataChannelUser;
use app\components\AnySDK;
use app\models\AnyOrderLogs;
use app\models\GmNotice;
use app\components\WxPayUnifiedOrder;
use app\components\WxPayConfig;
use app\components\WxPayApi;
use app\components\WxPayDataBase;
use app\components\WxPayBizPayUrl;
use app\models\LogMail;
use yii\helpers\Html;
use app\components\ipay;
use app\models\LogIpaynotice;
use app\models\CfgGameParam;
use app\models\CfgIpayParams;

class ShareController extends Controller
{
    
    public function actionDl()
    {
        $channel = Yii::$app->getRequest()->getQueryParam('cid');
        $this->layout="main_app";
        $updateinfo = GmChannelInfo::findOne(['cid'=>$channel]);
        if (!is_object($updateinfo))
        {
            throw new NotFoundHttpException();
        }else {
            return $this->render('tg',[
                'uinfo'=>$updateinfo,
                'cid'=>$channel,
            ]);
        }
    }
     
}
