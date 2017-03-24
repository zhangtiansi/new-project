<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmNoticeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '公告/活动';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-notice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建公告/活动', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name', 
            ['attribute'=>'tag',
            'format'=>'raw',
            'value'=>function($model){
                switch ($model->tag)
                {
                    case 0:
                        $hx="热门";
                        break;
                    case 1:
                        $hx="新增";
                        break;
                    case 2:
                        $hx="限时";
                        break;
                    default:
                        $hx="";
                        break;
                } 
                return $hx;
            },], 
            ['attribute'=>'type',
            'format'=>'raw',
            'value'=>function($model){
                $hx=$model->type==0?"公告":"活动";
                return $hx;
            },],
            'title',
            'content',
            'content_time',
            'tips',
            'utime',
             ['attribute'=>'status',
            'format'=>'raw',
            'value'=>function($model){
                $hx=$model->status==0?"生效":"失效";
                return $hx;
            },],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<script type="text/javascript">
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.gm-notice').addClass("active");
    $('.gm-notice').parent('ul').parent('li').addClass("active open");
});
</script>
