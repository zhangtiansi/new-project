<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogFriendsMsgsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '玩家聊天记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-friends-msgs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'from_uid',
            'to_uid',
            'msg_content',
            'ctime',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.logfriendsmsgs').addClass("active");
    $('.logfriendsmsgs').parent('ul').parent('li').addClass("active open");
     
   //logfirstorders
});
</script>