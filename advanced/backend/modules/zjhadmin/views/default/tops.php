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
 .ajax-loader{
    display:none;
 }
</style>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogCoinRecordsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '查询';
$this->params['breadcrumbs'][] = $this->title;
$uid = Yii::$app->getRequest()->getQueryParam('gid',0);
?>
<div class="log-coin-records-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
			<div class="col-xs-8">
			     <div>
			         <div class="input-group input-group-sm form-group-cus">
      				    <label>查询种类</label>
    					   <select id="ctype" >
                            <option value="1" selected="selected">充值排名</option>
                            <option value="2">个人充值明细</option>
                            <option value="3">客户端充值排名</option>
                            <option value="4">百人坐庄盈利榜</option>
                            <option value="5">百人坐庄亏损榜</option>
                            <option value="6">百人押注盈利榜</option>
                            <option value="7">百人总盈利榜</option> 
                            <option value="8">后台vip卡最多排行</option> 
                            <option value="9">渠道充值</option> 
                          </select>
    				</div> 
				    <div class="input-group input-group-sm form-group-cus">
      				    <label>uid</label>
    					<input type="text" id="uid-input" class="form-control" style="width: 300px;"  value="<?php echo $uid?>"/>
    				</div>
				</div>
				<div class="input-group input-group-sm form-group-cus">
				    <label>起始时间</label>
					<input type="text" id="bgtm" class="form-control" style="width: 300px;" value="<?php echo date('Y-m-d H:i:s',strtotime("-1 day"));?>"/>
					<span class="input-group-addon" style="width: 30px;">
						<i class="icon-calendar"></i>
					</span>
				</div>
				<div class="input-group input-group-sm form-group-cus" >
				    <label>结束时间</label>
					<input type="text" id="endtm" class="form-control" style="width: 300px;"  value="<?php echo date('Y-m-d H:i:s');?>"/>
					<span class="input-group-addon" style="width: 30px;">
						<i class="icon-calendar"></i>
					</span>
				</div>
				<div class="input-group input-group-sm form-group-cus"><a class='btn btn-info btn-xs ' id="coinSel" href="#">查询</a> <div class="ajax-loader">请稍后......</div></div>
				
			</div>
		</div>
    <div class="row">
	<div  class="col-xs-12">
    	<div class="table-header">
    			查询记录
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
    $('.logtops').addClass("active");
    $('.logtop').parent('ul').parent('li').addClass("active open");
    var fvTable;
    function showtable(uid,bgtm,endtm,ctype) {
        var  url;
        url = "/zjhadmin/default/getdata?uid="+uid+"&ctype="+ctype+"&bg=" + encodeURI(bgtm)+"&end="+encodeURI(endtm);
        $.ajax({
            type: 'GET',
            contentType: 'application/json; charset=utf-8',
            url: url, 
            dataType: 'JSON',
            beforeSend: function () {
                $('.ajax-loader').show();
            },
            success: function (response) { 
//                 $('.ajax-loader').hide();
                console.log(response);
                var tableColumns =response.aaData;
                var columns = [];
                var headers = '';
                var footers = ''; 
            	var firstItem =tableColumns[0] ;

            	for(key in firstItem) {
            	  console.log(key + ':' + firstItem[key]);
            	  var headerObj = new Object();
            	  headerObj['mData'] = key;  
            	  headerObj['sTitle'] = key;  
            	  columns.push(headerObj);
            	} 
 
                console.log(columns);
                //  insert header and footer into the table
//                 $('#coinTable thead tr').html(headers);
//                 $('#coinTable tfoot tr').html(footers);
            $('#coinTable').html('');
            if (typeof fvTable == 'undefined' && fvTable != null) { //为了避免多次初始化datatable()
                    console.log("tb undefined or null");
                    fvTable.fnClearTable(0); //清空数据
                    fvTable.fnDraw(); //重新加载数据
        　　　　　　　 fvTable.fnAdjustColumnSizing(); //重新判断列宽度，实际执行并没有效果　
                }
                else {
            	console.log("fvTable2 not  undefined or null");
            	fvTable =$('#coinTable').dataTable({
//                     'bServerSide': true,
                    'sAjaxSource': url,
                    'bProcessing': true,
                    'aoColumns': columns,
                    dom: 'T<"clear">lfrtip',
                    'tableTools': {
//                         'sSwfPath': '/swf/copy_csv_xls_pdf.swf'
                    },
                    'responsive': true,
//                     'lengthMenu': [[25, 50, 100, -1], [25, 50, 100, 'All']],
                    'fnInitComplete': function () {
                        console.log("called back draw");
                        $('.ajax-loader').hide();
                    },
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
                    "bDestroy": true,
                });
                }
            },
            error: function (result) {
                alert('Service call failed: ' + result.status + ' Type :' + result.statusText);
            }
        }); 
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
 	var uid=$("#uid-input").val();
 	var ctype=$("#ctype").val(); 
	var bgtm=$("#bgtm").val();
	var endtm=$("#endtm").val();
    $("#coinSel").on('click', function(e) {
		console.log("clicked coinselect");
		 uid=$("#uid-input").val();
	 	 ctype=$("#ctype").val(); 
		 bgtm=$("#bgtm").val();
		 endtm=$("#endtm").val();
		showtable(uid,bgtm,endtm,ctype);
	});
    //showtable(uid,bgtm,endtm,ctype);
});
</script>