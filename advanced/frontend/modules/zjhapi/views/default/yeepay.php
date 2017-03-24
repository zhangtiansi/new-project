
<div>
<div style="margin-top: 0;padding-top:0;width:100%;height:30px;text-align: center;font-size:25px" class="text-success"><p>充值中心</p></div>
<div style="padding-top: 10px"><p style="font-size:20px">您将要购买产品：<span class="text-danger"><?= $product_name ?>，</span>金额：<span class="text-danger"><?= $price ?></span>元</p></div>
<div>
<input type="radio" name="choose_card" value="SZX" /> 中国移动
<input type="radio" name="choose_card" value="TELECOM" /> 中国电信
<input type="radio" name="choose_card" value="UNICOM" /> 中国联通
</div>
<br>
</div>
<label for="card_num">卡号：</label>
<input type="text" name="card_num" value="" style="border:1px;border-radius:2px;min-width:200px"/>
<br />
<br />
<label for="card_passwd">密码：</label>
<input type="text" name="card_passwd" value="" style="border:1px;border-radius:2px;min-width:200px"/>
<br />
<br />
<div>
<a class="btn btn-success btn-large" style="width:100%;display: block" href="#" id="recharge">立即充值</a>
<br />
<br />
</div>
<div style="border:1px;border-radius:3px;border-color:gray">
<p style="font-size:20px" >【重要提示】</p>
<p style="font-size:17px" >※移动：</p>
<p style="color:red;">
※请务必使用与此面额相同的移动充值卡，否则会导致支付不成功，或支付金额丢失。（使用面额100元的移动充值卡但选择50元，高于50元部分不返还；使用50元卡但选择100元，支付失败，50元不返还。）
※不支持彩铃充值卡和短信充值卡，选择任何面额彩铃充值卡，将不予退还任何金额。</p>
<p style="font-size:17px" >※电信：</p>
<p style="color:red;">
※请务必使用与您所选择的面额相同的电信卡进行支付,否则引起的交易失败或交易金额丢失，我方不予承担！
※暂不支持电信流量卡支付。</p>
<p style="font-size:17px" >※联通：</p><p style="color:red;">
※请务必使用与您选择的面额相同的联通充值卡进行支付，否则引起的交易失败交易金额不予退还。
※如：选择50元面额但使用100元卡支付，则系统认为实际支付金额为50元， 高于50元部分不予退还；选择50元面额但使用30元卡支付则系统认为支付失败， 30元不予退还。
</p>
<p style="font-size:20px" >【支持卡种】</p>
<p style="font-size:17px" >※移动：</p>
※全国卡：卡号17位、密码18位的阿拉伯数字
地方卡：
※浙江：卡号10位 密码8位
※福建：卡号16位 密码17位
<p style="font-size:17px" >※电信：</p>
※中国电信充值付费卡卡号19位，密码18位的阿拉伯数字（即：可拨打11888充值话费的卡）。
※目前只支持电信全国卡和广东卡，充值卡序列号第四位为"1"的卡为全国卡，为"2"的则为地方卡。
<p style="font-size:17px" >※联通：</p>
※联通全国卡，卡号15位阿拉伯数字，密码19位阿拉伯数字。
<p style="font-size:20px" >【支持面额】</p>
<p style="font-size:17px" >※移动：</p>
※全国卡： 10、20、30、50、100、300、500元
地方卡：
※浙江地方卡： 10、20、30、50、100、200、300、500元、1000元
※福建地方卡： 50、100元
<p style="font-size:17px" >※电信：</p>
※10元、20元、30元、50元、100元、200元、300元、500元。
<p style="font-size:17px" >※联通：</p>
※20元、30元、50元、100元、300元、500元
</div>

<script type="text/javascript">
$("#recharge").click(function(){
//     alert("充值！");
// 	console.log(" the card type choose is "+$("input[name='choose_card']:checked").val()+"   >>>>");
// 	console.log(" the card id is "+$("input[name='card_num']").val()+"   >>>>");
// 	console.log(" the card passwd is "+$("input[name='card_passwd']").val()+"   >>>>");
	var card = $("input[name='choose_card']:checked").val();
	var card_num = $("input[name='card_num']").val();
	var card_pwd = $("input[name='card_passwd']").val();
	$.ajax({
		 type: "POST",
		 url: '<?php echo Yii::$app->getRequest()->getUrl()?>',
		 data:{
			    card:card,
			    card_num:card_num,
			    card_pwd:card_pwd,
			 },
		 dataType: "json",
		 success: function(data) {
			 console.log(data);
		 }
		});
});
</script>

