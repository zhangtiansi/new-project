<!-- <script src="/assets/6c0ad4db/jquery.js"></script> -->
<!-- <script src="/assets/18c673af/yii.js"></script> -->
<!-- <script src="/assets/7bca57a6/js/bootstrap.js"></script> -->
<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use app\models\GmOrderlist;
?>
<div class="row">
	<h1>数据中心页</h1>
		<div class="col-xs-10 row-block">
		<?php foreach (Yii::$app->params['btnlist'] as $v){
		    echo $v;
		}?>
		</div>
		<div class="col-xs-12 row-block" id="datacontent">
		<?php 
    		switch ($datatype){
    		    case GmOrderlist::DATA_TYPE_RECHARGE:
    		        {
    		            echo '<table class="table table-striped table-bordered detail-view">
    		            <tbody>
    		            <tr><td>日期</td><td>渠道</td><td>充值来源</td><td>充值金额</td><td>充值人数</td><td>充值笔数</td><td>Up值</td><td>单笔均值</td></tr>';
    		              foreach ($models as $model) {
    		                  echo '<tr><td>'.$model['udate'].'</td><td>'.$model['channel_name'].'</td><td>'.$model['source'].'</td><td>'.$model['totalfee'].'</td><td>'.$model['pnum'].'</td>
    		                      <td>'.$model['num'].'</td><td>'.Yii::$app->formatter->asDecimal($model['up'],2).'</td><td>'.Yii::$app->formatter->asDecimal($model['avg'],2).'</td></tr>';
    		              }
    		              echo '</tbody></table>';
    		              break;
    		        }
    		    case GmOrderlist::DATA_TYPE_USER:
    		        {
//     		              echo '<table class="table table-striped table-bordered detail-view">
//     		                      <tbody>
//     		                      <tr><td>日期</td><td>渠道</td><td>注册人数</td><td>登录人数</td><td>登录人次</td></tr>';
//     		              foreach ($models as $model) {
//     		                  echo '<tr><td>'.$model['udate'].'</td><td>'.$model['channel_name'].'</td><td>'.$model['totalreg'].'</td><td>'.$model['loginp'].'</td><td>'.$model['loginnum'].'</td></tr>';
//     		              }
//     		              echo '</tbody></table>';
//     		              break;
    		        } 
		        case GmOrderlist::DATA_TYPE_STAY2:
		            {
		                foreach ($models as $model) {
		                    echo "<br />";
		                }
		                break;
		            }
	            case GmOrderlist::DATA_TYPE_STAY3:
	                {
	                    foreach ($models as $model) {
	                        echo "<br />";
	                    }
	                    break;
	                }
                case GmOrderlist::DATA_TYPE_STAY7:
                    {
                        foreach ($models as $model) {
                            echo "<br />";
                        }
                        break;
                    }
                case GmOrderlist::DATA_TYPE_STAYPAY:
                    {
                        foreach ($models as $model) {
                            echo "<br />";
                        }
                        break;
                    }
    		}
    		
    		
    		// 显示分页
    		echo LinkPager::widget([
    		    'pagination' => $pages,
    		]);
		
		?>
		<?//= GridView::widget([
//         'dataProvider' => $dataProvider,
//         'filterModel' => '',
//         'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],
//             ['label'=>'日期','value'=>'udate'],
//             ['label'=>'渠道','value'=>'account.channels.channel_name'],
//             'source',
//             ['label'=>'金额','value'=>'totalfee'],
//             ['class' => 'yii\grid\ActionColumn'],
//         ],
//     ]); ?>
		
		</div>
	</div>

<style>
.row-block{
margin-left: 0px;
  margin-top: 10px;
  padding: 30px 15px 15px;
  border: 1px solid #DDDDDD;
  border-radius: 4px;
  position: relative;
  word-wrap: break-word;
}
<!--

-->
</style>
<script>
// var dailyuser = $("#dailyuser");
// var dailyrecharge = $("#dailyrecharge");
// var daily2stay = $("#daily2stay");
// var daily3stay = $("#daily3stay");
// var daily7stay = $("#daily7stay");
// var dailypaystay = $("#dailypaystay");


// function tpl(array,items,dataid){
// 	for (var i in items){
// 		var item = items[i];
// 		if(dataid=="1"){//dailyuser
// 			var li = '<li><a href="'+item.url+'">'+item.content+'</a></li>'; 
// 		}else if(dataid=="2"){//dailyrecharge
// 			var li = '<li><a href="'+item.url+'">'+item.content+'</a></li>'; 
// 		}else if(dataid=="3"){//daily2stay
// 			var li = '<li><a href="'+item.url+'">'+item.content+'</a></li>'; 
// 		}else if(dataid=="4"){//daily3stay
// 			var li = '<li><a href="'+item.url+'">'+item.content+'</a></li>'; 
// 		}else if(dataid=="5"){//daily7stay
// 			var li = '<li><a href="'+item.url+'">'+item.content+'</a></li>'; 
// 		}else if(dataid=="6"){//dailypaystay
// 			var li = '<li><a href="'+item.url+'">'+item.content+'</a></li>'; 
// 		}
//     	array.push(li);
// 	}
// }

// function loadAjaxdata(dataid){
// 	$.ajax({
// 		 type: "GET",
// 		 url: '/zjhadmin/default/getdata?type='+dataid,
// 		 dataType: "json",
// 		 success: function(data) {
// 			 console.log(data);
// 			 if(data.code == 0 ){
// 				 var appendarr=[];
// 					var items=data.results;
// 					tpl(appendarr,items,dataid);
// 					$("#datacontent").html(appendarr.join(''));
// 				 }
// 		 }
// 		});
// }

// dailyuser.bind("click",function(){
// 	alert("dailyuser click");
// });

// dailyrecharge.bind("click",function(){
// 	alert("dailyrecharge click");
// });

// daily2stay.bind("click",function(){
// 	alert("daily2stay click");
// });

// daily3stay.bind("click",function(){
// 	alert("daily3stay click");
// });

// daily7stay.bind("click",function(){
// 	alert("daily7stay click");
// });

// dailypaystay.bind("click",function(){
// 	alert("dailypaystay click");
// });


</script>
