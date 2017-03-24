<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CfgBetconfig */

$this->title = "时时乐全局参数配置";
$this->params['breadcrumbs'][] = ['label' => 'Cfg Betconfigs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-betconfig-view">

    <h1><?= Html::encode($this->title) ?></h1>

        <?php 
//          Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php 
//          Html::a('Delete', ['delete', 'id' => $model->id], [
//             'class' => 'btn btn-danger',
//             'data' => [
//                 'confirm' => 'Are you sure you want to delete this item?',
//                 'method' => 'post',
//             ],
//         ]) 
        ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'min_num',
            'max_num',
            'ntime',
            'num_yu',
            'num_coin',
            'bidnow',
        ],
    ]) ?>
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
// 	console.log(location.hostname);
//     $('li.active').removeClass("active open");
//     $('.opsagent').addClass("active");
//     $('.opsagent').parent('ul').parent('li').addClass("active open");
    $( ".modyu" ).on('click', function(e) {
		e.preventDefault();
	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
		var dialog = $( "#dialog-message" ).removeClass('hide').dialog({
			modal: true,
			title: "修改时时乐阈值",
			title_html: true,
			buttons: [ 
				{
					text: "确定",
					"class" : "btn btn-primary btn-xs",
					click: function() {
						var money = $("#money").val();
						if(isNaN(money)){
						    alert("必须输入数字");
						    $( this ).dialog( "close" ); 
						}
						$.ajax({
				       		 type: "POST",
				       		 url: '/zjhadmin/betcfg/mod',
				       		 data:{
				         		    coin:coin,
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