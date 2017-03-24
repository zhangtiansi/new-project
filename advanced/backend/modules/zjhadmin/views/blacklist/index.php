<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogBlacklistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '设备黑名单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-blacklist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建黑名单ime号', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'ime',
            [
                'attribute'=>'status',
                'format'=>'raw',
                'value'=>function($model){
                    return $model->status==0?
                    "设备已入黑名单 ".Html::a("解除设备黑名单",'#',['class'=>'btn btn-warning btn-xs black-ime','data-ime'=>$model->ime])
                    :"设备已解除黑名单 ".Html::a("禁止设备登录",'#',['class'=>'btn btn-warning btn-xs unblack-ime','data-ime'=>$model->ime]);
                },
            ],
//             'status',
            'ctime',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
	$('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.blacklist').addClass("active");
    $('.blacklist').parent('ul').parent('li').addClass("active open");

    $( ".black-ime" ).on('click', function(e) {
		e.preventDefault();
	    var ime =$(this).data("ime"); 
	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
		$.ajax({
	       		 type: "GET",
	       		 url: '/zjhadmin/default/blacklist?type=1&ime='+ime,
         		 dataType: "json",
         		 success: function(data) {
         			 console.log(data);
         			 if(data.code == 0 ){//success
         				alert("添加黑名单成功");
						location.reload() ;
         		      }else{
       		    	    alert(data.msg);
                    	}
         		 },
         		error:function(){
    				alert("提交失败，请检查网络");
    		        },
	       		});
	});

    $( ".unblack-ime" ).on('click', function(e) {
		e.preventDefault();
	    var ime =$(this).data("ime"); 
	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
		$.ajax({
	       		 type: "GET",
	       		 url: '/zjhadmin/default/unblacklist?type=1&ime='+ime,
         		 dataType: "json",
         		 success: function(data) {
         			 console.log(data);
         			 if(data.code == 0 ){//success
         				alert("解除黑名单成功");
						location.reload() ;
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