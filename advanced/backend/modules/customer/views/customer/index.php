<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'gid',
            'point',
            'coin',
            'propid',
            // 'propnum',
            // 'card_g',
            // 'card_s',
            // 'card_c',
            // 'status',
            // 'ctime',
            // 'ops',
            // 'desc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
