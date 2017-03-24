<link rel="stylesheet" href="/assets/admin/css/jquery-ui-1.10.3.full.min.css" />
<style>
.form-group-cus {
    margin-bottom: 10px;
    max-width: 400px;
    display: -webkit-inline-box;
}
.form-cus{
    width: 100px;
    max-width: 100px;
 }   
</style>
<?php

use yii\helpers\Html;
use app\models\GmAnnouncement;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgBetconfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '时时乐押注配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div >
    
    <div class="row">
	<div class="col-xs-12">
		<h3 class="header smaller lighter blue">时时乐概率计算</h3>
    <div class="row">
			<div class="col-xs-8">
				<div class="input-group input-group-sm form-group-cus">
					<input type="text" id="bgtm" class="form-control" style="width: 300px;" value="<?php echo date('Y-m-d H:i:s',strtotime("-1 day"));?>"/>
					<span class="input-group-addon" style="width: 30px;">
						<i class="icon-calendar"></i>
					</span>
				</div>
				<div class="input-group input-group-sm form-group-cus" >
					<input type="text" id="endtm" class="form-control" style="width: 300px;"  value="<?php echo date('Y-m-d H:i:s');?>"/>
					<span class="input-group-addon" style="width: 30px;">
						<i class="icon-calendar"></i>
					</span>
				</div>
				<div class="input-group input-group-sm form-group-cus"><a class='btn btn-info btn-xs ' id="sslsel22" href="#">查询</a></div>
			</div>
		</div>
		<div class="table-header">
			时时乐概率分布
		</div>
    <div class="table-responsive">
	<table id="sample-table-2" class="table table-striped table-bordered table-hover">
	</table>
	</div>
	<div class="table-header">
			时时乐TOP10
		</div>
    <div class="table-responsive">
	<table id="sample-table-3" class="table table-striped table-bordered table-hover">
	</table>
	</div>
	</div>

	</div>
	
	<div class="widget-box">
    	<div class="widget-header widget-header-flat">
    		<h4>当前概率配置</h4>
    	</div>
    
    	<div class="widget-body">
    		<div class="widget-main">
    			<div class="row">
    				<h4>4路牌起止点数：</h4>
    				<div id="point"></div>
    				<?php if (Yii::$app->user->id == 53||Yii::$app->user->id == 55 ):?>
    				    <a class="btn btn-danger" id="piont-mod">修改</a>
    				<?php endif?>
    			</div>
    			<hr>
    			<div class="row">
    				<h4>单独牌型配置：</h4><p class="tip">未开启表示没有控制牌型，已开启中各列表示开完该牌型后二次选择的配比,10000减去 横向各牌型配比总和即为该牌型剩余的配比</p>
    				<div id="cardtype"></div>
    			</div>
    		</div>
    	</div>
    </div>
    <script src="/assets/admin/js/jquery.dataTables.min.js"></script>
		<script src="/assets/admin/js/jquery.dataTables.bootstrap.js"></script>

<div id="dialog-message" class="hide">
    <div class="input-group input-group-xl">
    		<div class=" ">
    		<p>第1路</p>
    		<input type="text" name="sslp1" class="form-control sslp" placeholder="1路起点">
    		<input type="text" name="sslp2" class="form-control sslp" placeholder="1路止点"></div>
    		<div class=" ">
    		<p>第2路</p>
    		<input type="text" name="sslp3" class="form-control sslp" placeholder="2路起点">
    		<input type="text" name="sslp4" class="form-control sslp" placeholder="2路止点"></div>
    		<div class=" ">
    		<p>第3路</p>
    		<input type="text" name="sslp5" class="form-control sslp" placeholder="3路起点">
    		<input type="text" name="sslp6" class="form-control sslp" placeholder="3路止点"></div>
    		<div class=" ">
    		<p>第4路</p>
    		<input type="text" name="sslp7" class="form-control sslp" placeholder="4路起点">
    		<input type="text" name="sslp8" class="form-control sslp" placeholder="4路止点"></div>
    </div>
</div> 
<div id="dialog-message2" class="hide">
    <div class="input-group input-group-xl">
    		<h4>金花配比</h4>
    		<input type="text" name="sslc1" class="form-control sslc" placeholder="金花配比">
    		<h4>顺子配比</h4>
    		<input type="text" name="sslc2" class="form-control sslc" placeholder="顺子配比">
    		<h4>对子配比</h4>
    		<input type="text" name="sslc3" class="form-control sslc" placeholder="对子配比">
    		<h4>散牌配比</h4>
    		<input type="text" name="sslc4" class="form-control sslc" placeholder="散牌配比">
    </div>
</div> 
</div>
<script>
jQuery(function($) {
// 	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.ops-ssl').addClass("active");
    $('.ops-ssl').parent('ul').parent('li').addClass("active open");
    
    var fvTable;
    function showSSLtable(bgtm,endtm) {
        var  url;
        url = "/zjhadmin/default/getsslper?bg=" + encodeURI(bgtm)+"&end="+encodeURI(endtm);
        console.log("url :"+url+" bg :"+bgtm+" end : "+endtm);
        if (typeof fvTable == 'undefined' && fvTable != null) { //为了避免多次初始化datatable()
            console.log("tb undefined or null");
            fvTable.fnClearTable(0); //清空数据
            fvTable.fnDraw(); //重新加载数据
　　　　　　　//fvTable.fnAdjustColumnSizing(); //重新判断列宽度，实际执行并没有效果　
        }
        else {
        	console.log("tb not  undefined or null");
            fvTable = $('#sample-table-2').dataTable( {
            	        	"aoColumns" : [{
            	        		"mData" : 'result',
            	        		"sTitle" : "结果",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'xnum',
            	        		"sTitle" : "计数",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'ttall',
            	        		"sTitle" : "总数",
            	        		"bSortable" : true,
            	        		
            	        	},{
            	        		"mData" : 'per',
            	        		"sTitle" : "概率",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'reward',
            	        		"sTitle" : "单注回报率",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'totalOut',
            	        		"sTitle" : "总返奖",
            	        		"bSortable" : true,
//             	        		"mRender" : function(data, type, row) {
//             	        			return data+"万";
//             	        		}
            	        	},{
            	        		"mData" : 'totalNum',
            	        		"sTitle" : "返奖次数",
            	        		"bSortable" : true
            	        	}],
                            "bDestroy": true,
//                             "bServerSide": true,
            	        	"sAjaxSource":url,
            	        } );
        }
        $(window).resize(function () {
            console.log("resize d!");
            fvTable.fnAdjustColumnSizing();
        });
    }
    var fvTable2;
    function showSSLtableWinner(bgtm,endtm) {
        var  url;
        url = "/zjhadmin/default/getsslwin?bg=" + encodeURI(bgtm)+"&end="+encodeURI(endtm);
        console.log("url :"+url+" bg :"+bgtm+" end : "+endtm);
        if (typeof fvTable2 == 'undefined' && fvTable2 != null) { //为了避免多次初始化datatable()
            console.log("tb undefined or null");
            fvTable2.fnClearTable(0); //清空数据
            fvTable2.fnDraw(); //重新加载数据
　　　　　　　//fvTable2.fnAdjustColumnSizing(); //重新判断列宽度，实际执行并没有效果　
        }
        else {
        	console.log("fvTable2 not  undefined or null");
        	fvTable2 = $('#sample-table-3').dataTable( {
        		            "aaSorting": [[3, "desc" ]] ,
            	        	"aoColumns" : [{
            	        		"mData" : 'gid',
            	        		"sTitle" : "GID",
            	        		"bSortable" : false,
            	        		"mRender" : function(data, type, row) {
            	        			return '<a class="btn btn-minier btn-purple" href="/zjhadmin/player/view?id='+data+'">'+data+'</a>';
            	        		}
            	        	},{
            	        		"mData" : 'name',
            	        		"sTitle" : "昵称",
            	        		"bSortable" : false
            	        	},{
            	        		"mData" : 'power',
            	        		"sTitle" : "VIP",
            	        		"bSortable" : false,
            	        	},{
            	        		"mData" : 'totalReward',
            	        		"sTitle" : "总奖金(万)",
            	        		"bSortable" : true,
//             	        		"mRender" : function(data, type, row) {
//             	        			return data+"万";
//             	        		}
//             	        		"asSorting": [ "desc" ], 
            	        	},],
            	        	
                            "bDestroy": true,
//                             "bServerSide": true,
            	        	"sAjaxSource":url,
            	        } );
        }
        $(window).resize(function () {
            console.log("resize d!");
            fvTable2.fnAdjustColumnSizing();
        });
    }
    $( "#bgtm" ).datepicker({
    	dateFormat:'yy-mm-dd 00:00:00',
		showOtherMonths: true,
		selectOtherMonths: false,
	});
    $( "#endtm" ).datepicker({
    	dateFormat:'yy-mm-dd 00:00:00',
		showOtherMonths: true,
		selectOtherMonths: false,
		
	});
    showSSLtable(0,0);
    showSSLtableWinner(0,0);
	$("#sslsel22").on('click', function(e) {
		console.log("clicked sslsel22");
		var bgtm=$("#bgtm").val();
		var endtm=$("#endtm").val();
		console.log("clicked  bg :"+bgtm+ " end : "+endtm);
		showSSLtable(bgtm,endtm);
		showSSLtableWinner(bgtm,endtm);
		});
    getssl4();
    function getssl4(){
    	$.ajax({
   		 type: "GET",
   		 url: '/zjhadmin/default/sslconf?type=ssl4',
   		 dataType: "json",
   		 success: function(data) {
   			 if(data.code == 0 ){
   				var appendarr=[];
   				var items=data.data;
   				tplssl4(appendarr,items);
   				$("#point").html(appendarr.join(''));
   				console.log(appendarr);
   				 }else{
   				alert(data.msg);
   			}
   		 }
   		});
        }
    
        function tplssl4(array,items){
            array.push('<table class="table table-bordered table-striped"><thead class="thin-border-bottom"><tr><th>id</th><th>起点</th><th>止点</th></tr></thead><tbody>');
            for (var i in items){
            var item = items[i];
            var li = '<tr><td>'+item.id+'</td><td>'+item.begin_id+'</td><td>'+item.end_id+'</td></tr>'; 
            array.push(li);
            }
            array.push('</tbody></table>');
        }
        function getsslcard(){
        	$.ajax({
       		 type: "GET",
       		 url: '/zjhadmin/default/sslconf?type=sslcard',
       		 dataType: "json",
       		 success: function(data) {
       			 if(data.code == 0 ){
       				var appendarr=[];
       				var items=data.data;
       				tplsslcard(appendarr,items);
       				$("#cardtype").html(appendarr.join(''));
       				if(data.hasaccess!=1){
       				    $(".card_mod").addClass("hide");
       				    $(".card_close").addClass("hide");
               		}
       				console.log(appendarr);
       				 }else{
       				alert(data.msg);
       			}
       		 }
       		});
            }
        
            function tplsslcard(array,items){
                array.push('<table class="table table-bordered table-striped"><thead class="thin-border-bottom"><tr><th>id</th><th>金花配比</th><th>顺子配比</th><th>对子配比</th><th>散牌配比</th><th>开启状态</th><th>描述</th></tr></thead><tbody>');
                for (var i in items){
                var item = items[i];
                var li = '<tr><td>'+item.id+'</td><td>'+item.cfg_jin+'</td><td>'+item.cfg_shun+'</td><td>'+item.cfg_dui+'</td><td>'+item.cfg_san+'</td><td>';
                if(item.staus=="1"){
                    li +='开启配比';
                    li +='<a class="btn btn-info btn-sm card_mod" data-id="'+item.id+'" data-desc="'+item.desc+'">点击修改</a> <a class="btn btn-danger btn-sm card_close" data-id="'+item.id+'" data-desc="'+item.desc+'">点击关闭</a>';
                }else if(item.staus=="0"){
                    li+='已关闭<a class="btn btn-info btn-sm card_mod" data-id="'+item.id+'" data-desc="'+item.desc+'">点击开启</a>';
                }
                li+='</td><td>'+item.desc+'</td></tr>'; 
                array.push(li);
                }
                array.push('</tbody></table>');
            }
            getsslcard();

       $( "#piont-mod" ).on('click', function(e) {
   		e.preventDefault();
   	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
   		var dialog = $( "#dialog-message" ).removeClass('hide').dialog({
   			modal: true,
   			title: "修改4路起止点数",
   			title_html: true,
   			buttons: [ 
   				{
   					text: "确定",
   					"class" : "btn btn-primary btn-xs",
   					click: function() {
   	   					var isvalidate = true;
   						var inputList = document.getElementsByClassName("sslp");
   						var appendarr=[];
   						for(i=0;i<inputList.length;i++){ 
   						// 这里弹出的就是'kk'，当然也可以根据需要输出别的。比如：list[i].id; list[i].value等等。
//    						   alert("i : "+i+" 值"+inputList[i].name + inputList[i].value);
   						   var re = /^[0-9]+.?[0-9]*$/;   //判断字符串是否为数字     //判断正整数 /^[1-9]+[0-9]*]*$/  
   						   if (!re.test(inputList[i].value)||inputList[i].value==""||inputList[i].value >13 ||inputList[i].value <2)
       					   {
   	       					   var xn=i+1;
       					        alert("第"+xn+"行 请输入2-13之间数字");
       					        isvalidate=false;
       					        return false;
       					   }
   						   appendarr.push("\""+inputList[i].name+"\":"+inputList[i].value);
   						}
   						if(inputList[0].value > inputList[1].value){
   						    alert("起点1不能大于止点");
   						    isvalidate=false;
   					        return false;
   	   					}
   						if(inputList[2].value > inputList[3].value){
   						    alert("起点2不能大于止点");
   						    isvalidate=false;
   					        return false;
   	   					}
   						if(inputList[4].value > inputList[5].value){
   						    alert("起点3不能大于止点");
   						    isvalidate=false;
   					        return false;
   	   					}
   						if(inputList[6].value > inputList[7].value){
   						    alert("起点4不能大于止点");
   						    isvalidate=false;
   					        return false;
   	   					}
   	   					if(isvalidate){
   	   				     var jstr = "[{"+appendarr.join(",")+"}]";
   						$.ajax({
				       		 type: "POST",
				       		 url: '/zjhadmin/default/modssl4',
				       		 data:{
				         		    jstr:jstr,
				         		   _csrf:csrfToken
				             		 },
				         		 dataType: "json",
				         		 success: function(data) {
				         			 console.log(data);
				         			 if(data.code == 0 ){//success
				         				alert(data.msg);
				         				getssl4();
				         		      }else{
				         		    	 alert(data.msg);
						              }
					         		      
				         		 },
			         		error:function(){
			    				alert("提交失败，请检查网络");
			    		        },
				       		});   
   	   	   				}
   						$( this ).dialog( "close" ); 
   					} 
   				}
   			]
   		});
        });

       $('body').on('click' , '.card_mod' , function(){//ajax 加载的class 需要在body上绑定
   	   		var id = $(this).attr('data-id');
   	   		var desc = $(this).attr('data-desc');
   	   	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
//    	   	    alert("clicked !!!"+desc);
   	   		var dialog = $( "#dialog-message2" ).removeClass('hide').dialog({
   	   			modal: true,
   	   			title: "修改牌型分配 "+desc+"总额10000",
   	   			title_html: true,
   	   			buttons: [ 
   	   				{
   	   					text: "确定",
   	   					"class" : "btn btn-primary btn-xs",
   	   					click: function() {
   	   	   					var isvalidate = true;
   	   						var inputList = document.getElementsByClassName("sslc");
   	   						var appendarr=[];
   	   						var total=0;
   	   						for(i=0;i<inputList.length;i++){ 
   	   						// 这里弹出的就是'kk'，当然也可以根据需要输出别的。比如：list[i].id; list[i].value等等。
//   	    						   alert("i : "+i+" 值"+inputList[i].name + inputList[i].value);
   	   						   var re = /^[0-9]+.?[0-9]*$/;   //判断字符串是否为数字     //判断正整数 /^[1-9]+[0-9]*]*$/  
   	   						   if (!re.test(inputList[i].value)||inputList[i].value==""||inputList[i].value >10000)
   	       					   {
   	   	       					   var xn=i+1;
   	       					        alert("第"+xn+"行 请输入0-10000之间数字");
   	       					        isvalidate=false;
   	       					        return false;
   	       					   }
   	   						   total+=parseInt(inputList[i].value);
   	   						   appendarr.push("\""+inputList[i].name+"\":"+inputList[i].value);
   	   						}
   	   						if(total > 10000){
   	   						    alert("总和不能大于10000！"+total);
   	   					        total=0;
   	   						    isvalidate=false;
   	   					        return false;
   	   	   					}else{
   	   	   	   					var lastp = 10000-parseInt(total);
   	   	   				       alert("当前牌型"+desc+"剩余配比 :"+lastp);
   	   	   	   	   			}
   	   	   					if(isvalidate){
   	   	   				    var jstr = "[{"+appendarr.join(",")+"}]";
   	   						$.ajax({
   					       		 type: "POST",
   					       		 url: '/zjhadmin/default/modssl4?type=card&modid='+id,
   					       		 data:{
   					         		    jstr:jstr,
   					         		   _csrf:csrfToken
   					             		 },
   					         		 dataType: "json",
   					         		 success: function(data) {
   					         			 console.log(data);
   					         			 if(data.code == 0 ){//success
   					         				alert(data.msg);
   					         		        getsslcard();
   					         		      }else{
   					         		    	 alert(data.msg);
   							              }
   						         		      
   					         		 },
   				         		error:function(){
   				    				alert("提交失败，请检查网络");
   				    		        },
   					       		});   
   	   	   	   				}
   	   						$( this ).dialog( "close" ); 
   	   					} 
   	   				}
   	   			]
   	   		});
   		/**
   		dialog.data( "uiDialog" )._title = function(title) {
   			title.html( this.options.title );
   		};
   		**/
   	});
       $('body').on('click' , '.card_close' , function(){//ajax 加载的class 需要在body上绑定
  	   		var id = $(this).attr('data-id');
  	   		var desc = $(this).attr('data-desc');
  	   	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
  	        alert("id : "+id+" desc :"+desc);
  	        $.ajax({
	       		 type: "POST",
	       		 url: '/zjhadmin/default/modssl4?type=cardclose&modid='+id,
	       		 data:{
	         		   _csrf:csrfToken
	             		 },
	         		 dataType: "json",
	         		 success: function(data) {
	         			 if(data.code == 0 ){//success
	         				alert(data.msg);
	         		        getsslcard();
	         		      }else{
	         		    	 alert(data.msg);
			              }
		         		      
	         		 },
         		error:function(){
    				alert("提交失败，请检查网络");
    		        },
	       		}); 
       });
});
</script>
