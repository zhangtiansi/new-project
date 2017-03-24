<?php
namespace app\components;

class ApiErrorCode
{
    public static $OK = array('code'=>0,'msg'=>'请求成功');
    //参数异常
    public static $invalidParam = array('code'=>1001,'msg'=>'参数错误');
    //校验错误
    public static $CheckFailed = array('code'=>1002,'msg'=>'校验失败');
    //token过期
    public static $TokenExpired = array('code'=>1003,'msg'=>'token过期');
    //token验证失败
    public static $TokenError = array('code'=>1004,'msg'=>'token验证失败');
    //应用约束错误
    public static $RuleError = array('code'=>1005,'msg'=>'应用错误');
    //设备未记录
    public static $NoAccountError = array('code'=>1006,'msg'=>'设备初次登录需要注册');
    //设备已注册绑定
    public static $AccountLoginError = array('code'=>1007,'msg'=>'设备已注册使用帐号密码登录');
    //用户名密码错误
    public static $AccountPwdError = array('code'=>1008,'msg'=>'用户名/密码错误');
    //用户不匹配
    public static $AccountError = array('code'=>1013,'msg'=>'用户设备号与id匹配错误');
    //appstore 收据异常
    public static $ReceiptStatusError = array('code'=>1009,'msg'=>'支付收据异常');
    //appstore 收据保存失败
    public static $ReceiptSaveError = array('code'=>1010,'msg'=>'收据保存异常');
    //更新订单回调错误找不到订单号
    public static $OrderIdError = array('code'=>1011,'msg'=>'订单不存在');
    //查询产品productid失败
    public static $ProductidError = array('code'=>1012,'msg'=>'产品不存在');
    //查询receipt错误
    public static $ReceiptRuleError = array('code'=>1013,'msg'=>'收据发送错误');
    //查询record错误
    public static $RecordError = array('code'=>1014,'msg'=>'记录读取错误');
    //查询record错误
    public static $NoRecord = array('code'=>1015,'msg'=>'没有手动存档');
    //活动已经重置
    public static $ActivityHasReseted = array('code'=>1016,'msg'=>'活动已经重置');
    //转盘
    public static $LotteryError = array('code'=>1017,'msg'=>'转盘逻辑错误');
    //账户sim卡超过3个帐号
    public static $SimError = array('code'=>1018,'msg'=>'sim卡注册帐号过多');
    //账户名已经被注册
    public static $AccountNameError = array('code'=>1019,'msg'=>'用户名已经被占用');
    //忘记密码功能密保校验失败
    public static $AccountPwdqWrong = array('code'=>1020,'msg'=>'帐号不存在或密保问题和答案不正确');
    //
    public static $InvalidateRequest = array('code'=>1021,'msg'=>'无效请求');
    //sim卡为空
    public static $AccountSimNoneError = array('code'=>1022,'msg'=>'SIM卡为空，请插入SIM卡后注册');
    //易宝卡返回参数签名校验失败
    public static $YeepayCheckFailed = array('code'=>1023,'msg'=>'签名验证失败');
    //保存记录失败
    public static $SAVEERR = array('code'=>1024,'msg'=>'保存失败');
    //重载系统参数失败
    public static $ReloadSysParamERR = array('code'=>1025,'msg'=>'修改阈值成功，重载配置失败，请手动重载配置');
    //时时乐修改阈值失败
    public static $SetSSLcfgFailed = array('code'=>1026,'msg'=>'修改配置失败');
    //没有权限
    public static $AccessDenied = array('code'=>1027,'msg'=>'没有权限');
    
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