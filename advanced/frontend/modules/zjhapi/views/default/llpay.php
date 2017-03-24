
<div>
<div style="margin-top: 0;padding-top:0;width:100%;height:30px;text-align: center;font-size:25px" class="text-success"><p>充值中心</p></div>
<div style="padding-top: 10px"><p style="font-size:20px">您将要购买产品：<span class="text-danger"><?= $product_name ?>，</span>金额：<span class="text-danger"><?= $price ?></span>元</p></div>

<br>
</div>
<form id='llpaysubmits' name='llpaysubmits' action='<?php echo Yii::$app->getRequest()->getUrl()?>' method='POST'>
<label for="card_no">银行卡卡号：</label>
<input type="text" name="card_no" value="" style="border:1px;border-radius:2px;min-width:300px"/>
 <br />
<br />

<div>
<input class="btn btn-success btn-large" style="width:100%;display: block" id="recharge" type="submit">确认</input>
<div class="tips">如果您点击“确认”按钮，即表示您同意该次的执行操作，我们不会泄露任何您的个人隐私数据。</div>
<br />
<br />
</div>
</form>


<script type="text/javascript">
$("#recharge").click(function(){
	console.log(" the card card no is "+$("input[name='card_no']").val()+"   >>>>");
// 	console.log(" the card acct_name is "+$("input[name='acct_name']").val()+"   >>>>");
// 	console.log(" the card id_no is "+$("input[name='id_no']").val()+"   >>>>");
	var card_no  = $("input[name='card_no']").val();
// 	var acct_name = $("input[name='acct_name']").val();
// 	var id_no = $("input[name='id_no']").val();
	function StandardPost(url,args) 
    {
//         var form = $("<form method='post'></form>");
//         form.attr({"action":url});
//         for (arg in args)
//         {
//             var input = $("<input type='hidden'>");
//             input.attr({"name":arg});
//             input.val(args[arg]);
//             form.append(input);
//         }
            var html = "<form id='llpaysubmit' name='llpaysubmit' action='" +url+ "' method='POST'>";
            html += "<input type='hidden' name='req_data' value='"+args['req_data']+"'/>";
            //submit按钮控件请不要含有name属性
            html+= "<input type='submit'  ></form>";
//             $("#llp").html(html);
         var form = document.forms['llpaysubmit'];
         console.log(form);
//          form.submit();
    }
	$.ajax({
		 type: "POST",
		 url: '<?php echo Yii::$app->getRequest()->getUrl()?>',
		 data:{
			 card_no:card_no,
// 			 acct_name:acct_name,
// 			 id_no:id_no,
			 },
		 dataType: "json",
		 success: function(data) {
// 			 console.log(data);
			 StandardPost(data.redurl,data.args);
		 }
		});
	
});
</script>

