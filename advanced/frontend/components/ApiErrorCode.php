<?php
namespace app\components;

class ApiErrorCode
{
    public static $OK = array('code'=>0,'msg'=>'请求成功');
    //参数异常
    public static $invalidParam = array('code'=>1001,'msg'=>'参数错误,有问题请联系客服QQ群175349188，QQ:175349188');
    //校验错误
    public static $CheckFailed = array('code'=>1002,'msg'=>'校验失败,有问题请联系客服QQ群175349188，QQ:175349188');
    //token过期
    public static $TokenExpired = array('code'=>1003,'msg'=>'token过期');
    //token验证失败
    public static $TokenError = array('code'=>1004,'msg'=>'token验证失败');
    //应用约束错误
    public static $RuleError = array('code'=>1005,'msg'=>'应用错误,有问题请联系客服QQ群175349188，QQ:175349188');
    //设备未记录
    public static $NoAccountError = array('code'=>1006,'msg'=>'设备初次登录需要注册');
    //设备已注册绑定
    public static $AccountLoginError = array('code'=>1007,'msg'=>'校验失败，请重新登录,有问题请联系客服QQ群175349188，QQ:175349188');
    //用户名密码错误
    public static $AccountPwdError = array('code'=>1008,'msg'=>'用户名/密码错误');
    //用户不匹配
    public static $AccountError = array('code'=>1013,'msg'=>'用户设备号与id匹配错误,有问题请联系客服QQ群175349188，QQ:175349188');
    //appstore 收据异常
    public static $ReceiptStatusError = array('code'=>1009,'msg'=>'支付收据异常');
    //appstore 收据保存失败
    public static $ReceiptSaveError = array('code'=>1010,'msg'=>'收据保存异常');
    //更新订单回调错误找不到订单号
    public static $OrderIdError = array('code'=>1011,'msg'=>'订单不存在,有问题请联系客服QQ群175349188，QQ:175349188');
    //查询产品productid失败
    public static $ProductidError = array('code'=>1012,'msg'=>'产品不存在,有问题请联系客服QQ群175349188，QQ:175349188');
    //查询receipt错误
    public static $ReceiptRuleError = array('code'=>1013,'msg'=>'收据发送错误,有问题请联系客服QQ群175349188，QQ:175349188');
    //查询record错误
    public static $RecordError = array('code'=>1014,'msg'=>'记录读取错误');
    //查询record错误
    public static $NoRecord = array('code'=>1015,'msg'=>'没有手动存档');
    //活动已经重置
    public static $ActivityHasReseted = array('code'=>1016,'msg'=>'活动已经重置');
    //转盘
    public static $LotteryError = array('code'=>1017,'msg'=>'转盘逻辑错误');
    //账户sim卡超过3个帐号
    public static $SimError = array('code'=>1018,'msg'=>'您已经使用该手机注册了5个账号，无法再继续注册');
    //账户名已经被注册
    public static $AccountNameError = array('code'=>1019,'msg'=>'用户名已经被占用,有问题请联系客服QQ群175349188，QQ:175349188');
    //账户名已经被注册
    public static $PhoneError = array('code'=>1033,'msg'=>'手机号已经被占用,有问题请联系客服QQ群175349188，QQ:175349188');
    //忘记密码功能密保校验失败
    public static $AccountPwdqWrong = array('code'=>1020,'msg'=>'帐号不存在或密保问题和答案不正确');
    //
    public static $InvalidateRequest = array('code'=>1021,'msg'=>'无效请求,有问题请联系客服QQ群175349188，QQ:175349188');
    //sim卡为空
    public static $AccountSimNoneError = array('code'=>1022,'msg'=>'SIM卡为空，请插入SIM卡后注册,有问题请联系客服QQ群175349188，QQ:175349188');
    //易宝卡返回参数签名校验失败
    public static $YeepayCheckFailed = array('code'=>1023,'msg'=>'签名验证失败,有问题请联系客服QQ群175349188，QQ:175349188');
    //摇钱树保存信息失败
    public static $TreeDoFailed = array('code'=>1024,'msg'=>'摇钱树领取失败,有问题请联系客服QQ群175349188，QQ:175349188');
    //黑名单用户
    public static $BlackListError = array('code'=>1025,'msg'=>'用户账户异常,有问题请联系客服QQ群175349188，QQ:175349188');
    //黑名单广告用户
    public static $BlackListxError = array('code'=>1036,'msg'=>'您的账户异常登录,联系客服QQ群175349188，QQ:175349188');
    //短信限额
    public static $smsDayTomuchError = array('code'=>1026,'msg'=>'您当天短信充值已达限额，请更换充值方式');
    //短信限额
    public static $smsMonthTomuchError = array('code'=>1027,'msg'=>'您本月短信充值已达限额，请更换充值方式');
    //短信限额
    public static $smsError = array('code'=>1031,'msg'=>'运营商短信充值暂时不可用，请用微信或支付宝充值，谢谢。');
    //服务器正在维护
    public static $ServiceNotValiable = array('code'=>1028,'msg'=>'服务器正在维护，请稍后..加入客服QQ群518250970以获取最新情况');
    //生成订单失败
    public static $PlayerInfoError = array('code'=>1029,'msg'=>'您的账户生成订单异常,请联系客服QQ群175349188，QQ:175349188');
    //登录太频繁限制
    public static $RequestToMuch = array('code'=>1030,'msg'=>'您登录过于频繁,请1分钟后重试');
    public static $verError = array('code'=>1032,'msg'=>'短信验证码校验有误，');

    //校验出错
    public static $BindcheckError = array('code'=>1034,'msg'=>'验证码校验出错，请重试');
    public static $ALREADYBIND = array('code'=>1035,'msg'=>'您已经绑定其他手机号，不要再重复绑定');
}


class YeepayResult
{
    public static $OK=['code'=>0,'msg'=>'销卡成功，订单成功'];
    public static $PayOrderfailed=['code'=>1,'msg'=>'销卡成功，订单失败'];
    public static $Cardrulefailed=['code'=>7,'msg'=>'卡号卡密或卡面额不符合规则'];
    public static $CardFrequencefailed=['code'=>1002,'msg'=>'本张卡密您提交过于频繁，请您稍后再试'];
    public static $CardNotSupported=['code'=>1003,'msg'=>'不支持的卡类型（比如电信地方卡）'];
    public static $PasswdInvalide=['code'=>1004,'msg'=>'密码错误或充值卡无效'];
    public static $CardInv=['code'=>1006,'msg'=>'充值卡无效'];
    public static $CardNotEnough=['code'=>1007,'msg'=>'卡内余额不足'];
    public static $Cardexpire=['code'=>1008,'msg'=>'余额卡过期（有效期1个月）'];
    public static $CardInProcess=['code'=>1010,'msg'=>'此卡正在处理中'];
    public static $Unkown=['code'=>10000,'msg'=>'未知错误'];
    public static $CardisUsed=['code'=>2005,'msg'=>'此卡已使用'];
    public static $Fail2006=['code'=>2006,'msg'=>'卡密在系统处理中'];
    public static $Fail2007=['code'=>2007,'msg'=>'该卡为假卡'];
    public static $Fail2008=['code'=>2008,'msg'=>'该卡种正在维护'];
    public static $Fail2009=['code'=>2009,'msg'=>'浙江省移动维护'];
    public static $Fail2010=['code'=>2010,'msg'=>'江苏省移动维护'];
    public static $Fail2011=['code'=>2011,'msg'=>'福建省移动维护'];
    public static $Fail2012=['code'=>2012,'msg'=>'辽宁省移动维护'];
    public static $Fail2013=['code'=>2013,'msg'=>'该卡已被锁'];
    public static $Fail2014=['code'=>2014,'msg'=>'系统繁忙,请稍后重试'];
    
    /**
    0：销卡成功，订单成功
    1：销卡成功，订单失败
    7：卡号卡密或卡面额不符合规则
    1002：本张卡密您提交过于频繁，请您稍后再试
    1003：不支持的卡类型（比如电信地方卡）
    1004：密码错误或充值卡无效
    1006：充值卡无效
    1007：卡内余额不足
    1008：余额卡过期（有效期1个月）
    1010：此卡正在处理中
    10000：未知错误
    2005：此卡已使用
    2006：卡密在系统处理中
    2007：该卡为假卡
    2008：该卡种正在维护
    2009：浙江省移动维护
    2010：江苏省移动维护
    2011：福建省移动维护
    2012：辽宁省移动维护
    2013：该卡已被锁
    2014：系统繁忙,请稍后重试
    **/
}
?>