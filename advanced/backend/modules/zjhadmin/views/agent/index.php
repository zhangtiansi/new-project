<link rel="stylesheet" href="/assets/admin/css/jquery-ui-1.10.3.full.min.css" />
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AgentInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agent信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建Agent帐号', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label'=>'登录帐号','value'=>'account.username'],
            'agent_name',
            'money',
            'agent_desc',
            ['label'=>'操作',
                'format'=>'raw',
                'value'=>function($model){
                  $hx = Html::a('加钱','#',['class'=>'btn btn-minier btn-info addmoney','data-aid'=>$model->id,'data-aname'=>$model->agent_name,'data-amoney'=>$model->money]);
                  $hx.="  ";
                  $hx.= Html::a('修改','#',['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->id]);
                  $hx.="  ";
                  $hx.= Html::a('操作日志','/zjhadmin/sysoplogs?opid='.$model->account_id,['class'=>'btn btn-minier btn-warning']);
                  return $hx;
            },],
        ],
    ]); ?>
    <script src="/assets/admin/js/jquery-ui-1.10.3.full.min.js"></script>
    <script src="/assets/admin/js/jquery.ui.touch-punch.min.js"></script>
<div id="dialog-message" class="hide">
    <div class="input-group input-group-sm">
    		<input type="text" id="money" class="form-control">
    	</div>
</div><!-- #dialog-message -->
</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
	$('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.opsagent').addClass("active");
    $('.opsagent').parent('ul').parent('li').addClass("active open");
    $( ".modify" ).on('click', function(e) {
    	location.href='http://'+location.hostname+'/zjhadmin/agent/update?id='+$(this).data("aid");
        });
    $( ".addmoney" ).on('click', function(e) {
		e.preventDefault();
	    var aid =$(this).data("aid"); 
	    var aname=$(this).data("aname");
	    var amoney=$(this).data("amoney");
	    
	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
		var dialog = $( "#dialog-message" ).removeClass('hide').dialog({
			modal: true,
			title: "增加"+aname+"预存金,当前 "+amoney,
			title_html: true,
			buttons: [ 
				{
					text: "确定",
					"class" : "btn btn-primary btn-xs",
					click: function() {
						var money = $("#money").val();
						if(isNaN(money)){
// 						    alert("必须输入数字");
						    $( this ).dialog( "close" ); 
						}
						$.ajax({
				       		 type: "POST",
				       		 url: '/zjhadmin/agent/addmoney?aid='+aid,
				       		 data:{
				         		    money:money,
				         		   _csrf:csrfToken
				             		 },
				         		 dataType: "json",
				         		 success: function(data) {
				         			 console.log(data);
				         			 if(data.code == 0 ){//success
				         				alert("添加成功");
										location.reload() ;
				         		      }
				         		 },
			         		error:function(){
			    				alert("提交失败，请检查网络");
			    		        },
				       		});

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
});
</script>