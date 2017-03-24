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

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgBetconfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '时时乐押注配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div >
    
    <div class="row">
	<div class="col-xs-12">
		<h3 class="header smaller lighter blue">送礼排行榜</h3>
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
				</div>  <br>
				<div class="input-group input-group-sm " >
					<input type="text" id="from_uid" class="form-control" style="width: 300px;"  placeholder="赠送人id"/> 
				</div>  <br>
				<div class="input-group input-group-sm " >
					<input type="text" id="to_uid" class="form-control" style="width: 300px;"  placeholder="收礼人id" /> 
				</div> <br>
				<div class="input-group input-group-sm " >
					<input type="text" id="giftid" class="form-control" style="width: 300px;"  placeholder="礼物id，1鲜花2钻戒6城堡11仙草" /> 
				</div>  <br>
				<div class="input-group input-group-sm form-group-cus"><a class='btn btn-info btn-xs ' id="gifttops" href="#">查询</a></div>
			</div>
		</div>
		<div class="table-header">
			送礼排行榜
		</div>
    <div class="table-responsive">
	<table id="sample-table-2" class="table table-striped table-bordered table-hover">
	</table>
	</div> 
	</div>

	</div>
	
    <script src="/assets/admin/js/jquery.dataTables.min.js"></script>
		<script src="/assets/admin/js/jquery.dataTables.bootstrap.js"></script>
  
</div>
<script>
jQuery(function($) {
// 	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.gifttop').addClass("active");
    $('.gifttop').parent('ul').parent('li').addClass("active open"); 
    var fvTable;
    function showTopgift(bgtm,endtm,fromid,toid,giftid) {
        var  url;
        url = "/zjhadmin/loggift/gettopgift?bg=" + encodeURI(bgtm)+"&end="+encodeURI(endtm)+"&fromid=" + encodeURI(fromid)+"&toid="+encodeURI(toid)+"&giftid="+encodeURI(giftid);
        console.log("url :"+url+" bg :"+bgtm+" end : "+endtm);
        if (typeof fvTable == 'undefined' && fvTable != null) { //为了避免多次初始化datatable()
            console.log("tb undefined or null");
            fvTable.fnClearTable(0); //清空数据
            fvTable.fnDraw(); //重新加载数据
　　　　　　　//fvTable.fnAdjustColumnSizing(); //重新判断列宽度，实际执行并没有效果　
        }
        else {
        	console.log("tb defined or null");
            fvTable = $('#sample-table-2').dataTable( {
            	        	"aoColumns" : [{
            	        		"mData" : 'from_uid',
            	        		"sTitle" : "赠送人id",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'fromname',
            	        		"sTitle" : "赠送人",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'to_uid',
            	        		"sTitle" : "收礼人id",
            	        		"bSortable" : true,
            	        		
            	        	},{
            	        		"mData" : 'toname',
            	        		"sTitle" : "收礼人",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'prop_name',
            	        		"sTitle" : "礼品",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'ctuser',
            	        		"sTitle" : "人数",
            	        		"bSortable" : true,
//             	        		"mRender" : function(data, type, row) {
//             	        			return data+"万";
//             	        		}
            	        	},{
            	        		"mData" : 'ctnum',
            	        		"sTitle" : "数量",
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
    showTopgift(0,0,0,0,0); 
	$("#gifttops").on('click', function(e) {
		console.log("clicked sslsel22");
		var bgtm=$("#bgtm").val();
		var endtm=$("#endtm").val();
		var fromid=$("#from_uid").val();
		var toid=$("#to_uid").val();
		var giftid=$("#giftid").val(); 
	    showTopgift(bgtm,endtm,fromid,toid,giftid);  
		}); 
        
});
</script>
