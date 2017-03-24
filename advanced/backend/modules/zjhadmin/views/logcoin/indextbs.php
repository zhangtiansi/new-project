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
use yii\grid\GridView;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogCoinRecordsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '金币历史变更记录';
$this->params['breadcrumbs'][] = $this->title;
$uid = Yii::$app->getRequest()->getQueryParam('gid',0);
?>
<div class="log-coin-records-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
			<div class="col-xs-8">
			    <div class="input-group input-group-sm form-group-cus" >
				    <label>uid</label>
					<input type="text" id="uid-input" class="form-control" style="width: 300px;"  value="<?php echo $uid?>"/>
				</div>
				<div class="input-group input-group-sm form-group-cus">
					<input type="text" id="indate-input" class="form-control" style="width: 300px;" value="<?php echo date('ymd',strtotime("-1 day"));?>"/>
					<span class="input-group-addon" style="width: 30px;">
						<i class="icon-calendar"></i>
					</span>
				</div>
				<div class="input-group input-group-sm form-group-cus"><a class='btn btn-info btn-xs ' id="coinSel" href="#">查询</a></div>
			</div>
	 </div>
    <div class="row">
	<div  class="col-xs-12">
    	<div class="table-header">
    			金币记录
    	</div>
        <div class="table-responsive">
        	<table id="coinTable" class="table table-striped table-bordered table-hover">
        	</table>
    	</div>
	</div></div>
</div>
<script src="/assets/admin/js/jquery.dataTables.min.js"></script>
<script src="/assets/admin/js/jquery.dataTables.bootstrap.js"></script>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.logcoin').addClass("active");
    $('.logcoin').parent('ul').parent('li').addClass("active open");
    var uid=<?php echo $uid;?>;
    var fvTable;
    function showtable(uid,indate) {
        var  url;
        url = "/zjhadmin/logcoin/coin?uid="+uid+"&indate="+indate;
        if (typeof fvTable == 'undefined' && fvTable != null) { //为了避免多次初始化datatable()
            console.log("tb undefined or null");
            fvTable.fnClearTable(0); //清空数据
            fvTable.fnDraw(); //重新加载数据
　　　　　　　//fvTable.fnAdjustColumnSizing(); //重新判断列宽度，实际执行并没有效果　
　　　　　　　//id           | uid           | c_name           | change_coin           | change_after           | game_no           | prop_id           | ctime     
        }
        else {
        	console.log("tb not  undefined or null");
            fvTable = $('#coinTable').dataTable( {
                        	"oLanguage" : {
                        		"sLengthMenu" : "每页显示 _MENU_ 条记录",
                        		"sZeroRecords" : "对不起，没有匹配的数据",
                        		"sInfo" : "第 _START_ - _END_ 条 / 共 _TOTAL_ 条数据",
                        		"sInfoEmpty" : "没有匹配的数据",
                        		"sInfoFiltered" : "(数据表中共 _MAX_ 条记录)",
                        		"sProcessing" : "正在加载中...",
                        		"sSearch" : "全文搜索：",
                        		"oPaginate" : {
                        			"sFirst" : "第一页",
                        			"sPrevious" : " 上一页 ",
                        			"sNext" : " 下一页 ",
                        			"sLast" : " 最后一页 "
                        		}
                        	},
            	        	"aoColumns" : [{
            	        		"mData" : 'id',
            	        		"sTitle" : "id",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'uid',
            	        		"sTitle" : "uid",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'c_name',
            	        		"sTitle" : "变更类型",
            	        		"bSortable" : true,
            	        		
            	        	},{
            	        		"mData" : 'change_coin',
            	        		"sTitle" : "变更金币",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'change_after',
            	        		"sTitle" : "变更后",
            	        		"bSortable" : true
            	        	},{
            	        		"mData" : 'game_no',
            	        		"sTitle" : "game_no",
            	        		"bSortable" : true,
            	        		"mRender" : function(data, type, row) {
            	        			return  '<a class="btn btn-green btn-xs" href="'+'/zjhadmin/loggame?gameno='+data+'">'+data+'</a>';
            	        		} 
//             	        		"mRender" : function(data, type, row) {
//             	        			return data+"万";
//             	        		}
            	        	},{
            	        		"mData" : 'prop_id',
            	        		"sTitle" : "prop_id",
            	        		"bSortable" : true,
            	        		"mRender" : function(data, type, row) {
            	        			return  '<a class="btn btn-green btn-xs" href="'+'/zjhadmin/loggame?propid='+data+'">'+data+'</a>';
            	        		} 
            	        	},{
            	        		"mData" : 'ctime',
            	        		"sTitle" : "ctime",
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
    $( "#indate-input" ).datepicker({
    	dateFormat:'ymmdd',
		showOtherMonths: true,
		selectOtherMonths: false,
	});
    var indate=$("#indate-input").val();
	var uid=$("#uid-input").val();
	showtable(uid,indate);
    $("#coinSel").on('click', function(e) {
		console.log("clicked coinselect");
		indate=$("#indate-input").val();
		uid=$("#uid-input").val();
		showtable(uid,indate);
	});
});
</script>