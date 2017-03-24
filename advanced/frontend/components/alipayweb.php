<?php
namespace app\components;
use Yii;
class alipayweb
{
    
    public function payForwebAlipay()
    {
    //商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = $_POST['WIDout_trade_no'];
    
    //订单名称，必填
    $subject = $_POST['WIDsubject'];
    
    //付款金额，必填
    $total_amount = $_POST['WIDtotal_amount'];
    
    //商品描述，可空
    $body = $_POST['WIDbody'];
    
    //超时时间
    $timeout_express="1m";
    
    $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
    $payRequestBuilder->setBody($body);
    $payRequestBuilder->setSubject($subject);
    $payRequestBuilder->setOutTradeNo($out_trade_no);
    $payRequestBuilder->setTotalAmount($total_amount);
    $payRequestBuilder->setTimeExpress($timeout_express);
    
    $payResponse = new AlipayTradeService($config);
    $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
    
    }
    
    
}