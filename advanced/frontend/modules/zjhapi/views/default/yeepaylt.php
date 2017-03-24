
<div>
<div style="margin-top: 0;padding-top:0;width:100%;height:30px;text-align: center;font-size:25px" class="text-success"><p>充值中心</p></div>
<div style="padding-top: 10px"><p>您将要充值产品：<?= $productid ?>，金额：<?= $price ?>元</p></div>

</div>
<label for="card_num">卡号：</label>
<input type="text" name="card_num" value="" style="border:1px;border-radius:2px;min-width:200px"/>
<br/>
<label for="card_passwd">密码：</label>
<input type="text" name="card_passwd" value="" style="border:1px;border-radius:2px;min-width:200px"/>
<br>
<div>
<a class="btn btn-success btn-large" style="width:100%;display: block" href="http://baidu.com">立即充值</a>
</div>
<div style="border:1px;border-radius:3px;border-color:gray">
<p style="font-size:20px" >【重要提示】</p>
<p style="color:red;">※请务必使用与您选择的面额相同的联通充值卡进行支付，否则引起的交易失败交易金额不予退还。
※如：选择50元面额但使用100元卡支付，则系统认为实际支付金额为50元， 高于50元部分不予退还；选择50元面额但使用30元卡支付则系统认为支付失败， 30元不予退还。</p>
<p style="font-size:20px" >【支持卡种】</p>
※联通全国卡，卡号15位阿拉伯数字，密码19位阿拉伯数字。
<p style="font-size:20px" >【支持面额】</p>
※20元、30元、50元、100元、300元、500元
</div>

