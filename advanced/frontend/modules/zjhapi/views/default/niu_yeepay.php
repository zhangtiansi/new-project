<div class="c-om">
        <form name="form-yeepay" method="post" action="" id="yeepay-form">
        <div class="c-area">
            <ul class="ca-ul">
                <li class="ca-li">
                    <label class="ca-label">充值金额：</label>
                    <?php echo Yii::$app->getRequest()->getQueryParam('price');?>
                </li>
                <li class="ca-li">
                    <label class="ca-label">商品名称：</label>
                    <?php echo Yii::$app->getRequest()->getQueryParam('pname');?>
                </li>
            </ul>
        </div>
        <div class="c-cont">
            <div class="cc-tl">
                需要购买<span class="cct-money" id="J_money"></span>元充值卡完成充值
            </div>
            <div class="cc-lis" id="J_lis">
                <span class="cc-li"><i class="sel"></i></span>
            </div>
        </div>
        <ul class="c-cont c-form">
            <li class="ca-li">
                <label class="ca-label">充值卡号</label>
                <input type="text" class="ca-inp" id="J_card">
            </li>
            <li class="ca-li">
                <label class="ca-label">充值密码</label>
                <input type="text" class="ca-inp" id="J_passwd">
            </li>
        </ul>
        <div class="c-cont c-subm" id="chongzhi">
            <span class="cn-bton"></span>
        </div>
    </form>
    <div class="c-tip">
            <h2 class="ct-h2">【重要提示】</h2>
            <h3 class="ct-h3">※移动：</h3>
            <p class="ct-p">
                ※请务必使用与此面额相同的移动充值卡，否则会导致支付不成功，或支付金额丢失。（使用面额100元的移动充值卡但选择50元，高于50元部分不返还；使用50元卡但选择100元，支付失败，50元不返还。）<br>※不支持彩铃充值卡和短信充值卡，选择任何面额彩铃充值卡，将不予退还任何金额。
            </p>
            <h3 class="ct-h3">※电信：</h3>
            <p class="ct-p">
                ※请务必使用与您所选择的面额相同的电信卡进行支付,否则引起的交易失败或交易金额丢失，我方不予承担！<br>※暂不支持电信流量卡支付。
            </p>
            <h3 class="ct-h3">※联通：</h3>
            <p class="ct-p">
                ※请务必使用与您选择的面额相同的联通充值卡进行支付，否则引起的交易失败交易金额不予退还。<br>
                ※如：选择50元面额但使用100元卡支付，则系统认为实际支付金额为50元，高于50元部分不予退还；选择50元面额但使用30元卡支付则系统认为支付失败， 30元不予退还。
            </p>
            <h2 class="ct-h2">【支持卡种】</h2>
            <h3 class="ct-h3">※移动：</h3>
            <p class="ct-p">
                ※全国卡：卡号17位、密码18位的阿拉伯数字 地方卡： ※浙江：卡号10位 密码8位 ※福建：卡号16位 密码17位
            </p>
            <h3 class="ct-h3"> ※电信：</h3>
            <p class="ct-p">
                ※中国电信充值付费卡卡号19位，密码18位的阿拉伯数字（即：可拨打11888充值话费的卡）。<br>
                ※目前只支持电信全国卡和广东卡，充值卡序列号第四位为"1"的卡为全国卡，为"2"的则为地方卡。
            </p>
            <h3 class="ct-h3">※联通：</h3>
            <p class="ct-p">
                ※联通全国卡，卡号15位阿拉伯数字，密码19位阿拉伯数字。
            </p>
            <h2 class="ct-h2">【支持面额】</h2>
            <h3 class="ct-h3">※移动：</h3>
            <p class="ct-p">
                ※全国卡： 10、20、30、50、100、300、500元 <br>地方卡：※浙江地方卡：10、20、30、50、100、200、300、500元、1000元 ※福建地方卡： 50、100元
            </p>
            <h3 class="ct-h3">※电信：</h3>
            <p class="ct-p">
                ※10元、20元、30元、50元、100元、200元、300元、500元。
            </p>
            <h3 class="ct-h3">※联通：</h3>
            <p class="ct-p">
                ※20元、30元、50元、100元、300元、500元 
            </p>
        </div>
    </div>
<script type="text/javascript">
jQuery(function($) {
    var lis = document.getElementById('J_lis'); 
    var moneyEl =$('#J_money');
    var price ;
    var card = document.getElementById('J_card');
    var pass = document.getElementById('J_passwd');
    var OrderPrice='<?php echo Yii::$app->getRequest()->getQueryParam('price');?>';
    var moneys = [5,6,10,15,18,20,25,30,35,40,45,50,60,68,98,100,120,180,198,200,208,250,300,318,328,50,468,500,648,1000,1998,2000,2998,3000,3998,5000,10000];
    function chooseMoney(num){
        num = num ? parseInt(num,10) : 0;
        var result;
        for(var i=0,len=moneys.length;i<len;i++){
            if(num <= moneys[i]){
                result = moneys[i];
                break;
            }
        }
        lis.querySelector('i').classList.add('cc-li' + result);
        $('#J_money').text(result);
        price = result;
    }
    
    chooseMoney(OrderPrice);
  //TEST
    console.log("order prices--: "+OrderPrice+"  jmoney :-"+$('#J_money').text());
    $('#chongzhi').click(function(){
    //  alert("充值！money : "+moneyEl.value+" card :"+card.value+" J_passwd:"+ pass.value);
     console.log("post request start");
     var card = document.getElementById('J_card');
     var pass = document.getElementById('J_passwd');
//      alert("money select:"+price);
     $.ajax({
    	 type: "POST",
    	 url: '<?php echo Yii::$app->getRequest()->getUrl()?>',
    	 data:{
    		    card_num:card.value,
    		    card_pwd:pass.value,
    		    money:price,
    		 },
    	 dataType: "json",
    	 success: function(data) {
    		 console.log(data);
//                 alert(data.r0_Cmd+" code :"+data.r1_Code+" msg :"+data.r6_Order+" return :"+data.rq_ReturnMsg);
    		    window.location.href="yeepayresultniu?issuccess="+data.r1_Code;
    	 }
    	});
    });
});
</script>
