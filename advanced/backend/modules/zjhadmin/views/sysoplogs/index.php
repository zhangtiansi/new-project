<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use app\models\LogCustomer;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SysOplogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '操作日志';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-oplogs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ctime',
            ['attribute'=>'opid',
                'value'=>function($model){
                return User::getNamebyid($model->opid);
            }],
            'keyword',
             ['attribute'=>'cid',
                 'format'=>'raw',
                'value'=>function($model){
                if ($model->keyword=="addagentmoney"){
                    return $model->cid."RMB";
                }else {
                    return Html::a('赠送记录id:'.$model->cid,['customer/view','id'=>$model->cid]);
                }
            }],
            ['label'=>'操作金额',
            'format'=>'raw',
            'value'=>function($model){
                if ($model->keyword=="addagentmoney"){
                    return $model->cid."RMB";
                }else {
                    $logcid = LogCustomer::findOne(['id'=>$model->cid]);
                    if (is_object($logcid))
                    {
                        return Yii::$app->formatter->asDecimal($logcid->coin/80000,0) ."RMB ";
                    }else {
                        return Html::tag("p",".");
                    }
                }
            }],
            ['attribute'=>'gid',
            'format'=>'raw',
            'value'=>function($model){
                if ($model->keyword=="addagentmoney"){
                    return Html::a('Agent号id:'.$model->gid,['agent/view','id'=>$model->gid]);
                }else {
                    return Html::a('玩家id:'.$model->gid,['player/view','id'=>$model->gid]);
                }
            }],
            'logs',
            'desc',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.opslogs').addClass("active");
    $('.opslogs').parent('ul').parent('li').addClass("active open");
});
</script>
    