<script src="https://web.iapppay.com/h5/v1.0.1/js/aibei_v1.1.0.js"></script>
<?php 
$gid = Yii::$app->getRequest()->getQueryParam('gid');
$orderid = Yii::$app->getRequest()->getQueryParam('orderid');
?>
<div style="padding-top: 30px">
<p style="font-size: 30px">支付订单号<?php echo $orderid;?>,uid:<?php echo $gid;?></p>
<p style="font-size: 30px">支付成功后请关闭页面服务端会验证支付是否成功，有问题请联系客服</p>
</div>
<script type="text/javascript">  
jQuery(function($) {
    var aibeiPay = new AiBeiPay(); //初始化爱贝支付JS(此类有且只能创建一次)
    var gid = '<?php echo $gid?>';
    var orderid = '<?php echo $orderid?>';
    function payOrder(gid,orderid){
    	$.ajax({
   		 type: "GET",
   		 url: '/game/iappay?gid='+gid+'&orderid='+orderid+'&type=1',
   		 dataType: "json",
   		 success: function(data) {
   			 console.log(data);
   			 console.log("----data received end ");
   		     startpay(data);  
   		 }
   		});
    }
     
    function startpay(data){
    	aibeiPay.clickAibei(data);
    }
    function callbackData(data){
//     	{ Type:0, RetCode:0, TransId:”20150201000000000001”, OrderStatus:0,SignData:” transdata=…&sign=xxxxxx&signtype=RSA”}
        if(data.Type==1 && data.RetCode==0)
        {
            var strr="支付成功";
            console.log(strr);
        }
    }
    payOrder(gid,orderid);
});
</script>
