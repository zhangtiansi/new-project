<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogFriendaddSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Friendadds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-friendadd-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log Friendadd', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'aid_from',
            'from_name',
            'aid_to',
            'to_name',
            'type',
            'mark',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
