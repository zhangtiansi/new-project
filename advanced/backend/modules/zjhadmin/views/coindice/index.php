<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmAccountInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '玩家日金币变更信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coin-all-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            'gid', 'name','point', 'total_coin:integer', 'maxCoin:integer', 'totalwin:integer', 'totalbet:integer', 'totalchange:integer', 'winTime','ctime',
//             [
//             'attribute'=>'regtime',
//             'value'=>function($model){
//                 $x = date('Y-m-d',$model->regtime);
//                 return $x;
//             },
//             ],
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.coindice').addClass("active");
    $('.coindice').parent('ul').parent('li').addClass("active open");
    $('.gift').click(function(){
        location.href='http://'+location.hostname+'/zjhadmin/customer/create?uid='+$(this).data("player");
    });
});
</script>