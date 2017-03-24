
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
<p style="color:red;">※请务必使用与您所选择的面额相同的电信卡进行支付,否则引起的交易失败或交易金额丢失，我方不予承担！
※暂不支持电信流量卡支付。
</p>
<p style="font-size:20px" >【支持卡种】</p>
※中国电信充值付费卡卡号19位，密码18位的阿拉伯数字（即：可拨打11888充值话费的卡）。
※目前只支持电信全国卡和广东卡，充值卡序列号第四位为"1"的卡为全国卡，为"2"的则为地方卡。
<p style="font-size:20px" >【支持面额】</p>
※10元、20元、30元、50元、100元、200元、300元、500元。

</div>

