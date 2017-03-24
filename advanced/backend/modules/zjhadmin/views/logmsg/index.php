<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogFriendsMsgsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Friends Msgs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-friends-msgs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log Friends Msgs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'from_uid',
            'to_uid',
            'type',
            'status',
            // 'msg_content',
            // 'ctime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
