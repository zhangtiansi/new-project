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
    <script src="/assets/admin/js/jquery.dataTables.min.js"></script>
		<script src="/assets/admin/js/jquery.dataTables.bootstrap.js"></script>

<div id="dialog-message" class="hide">
    <div class="input-group input-group-sm">
    		<input type="text" id="money" class="form-control">
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
            	        		"mRender" : function(data, type, row) {
            	        			return data;
            	        		}
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
            	        		"bSortable" : true
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
            	        		"bSortable" : false
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
            	        		"bSortable" : false,
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
});
</script>
