<link rel="stylesheet" href="/assets/admin/css/jquery-ui-1.10.3.full.min.css" />
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgBetconfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '时时乐押注配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-betconfig-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'min_num',
            'max_num',
            'ntime',
            'num_yu',
            [
             'attribute'=>'num_coin',
                'format'=>'raw',
                'value'=>$model->num_coin.Html::a("修改阈值",'#',['class'=>'btn btn-warning btn-xs modyu']),
            ],
//             'num_coin',
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
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.ops-ssl').addClass("active");
    $('.ops-ssl').parent('ul').parent('li').addClass("active open");
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
						var coin = $("#money").val();
						if(isNaN(money)){
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
				         				alert("修改成功");
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
