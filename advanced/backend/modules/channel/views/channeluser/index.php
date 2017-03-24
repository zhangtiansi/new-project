<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DataChannelUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '渠道单日用户数据';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-channel-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//             'id',
            'udate',
            'channel',
//             'activenum',
            'regactive',

//             ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('li.active').removeClass("active open");
    $('.data-user').addClass("active");
    $('.data-user').parent('ul').parent('li').addClass("active open");
});
</script>