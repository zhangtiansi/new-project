<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmOrderlistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gm Orderlists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-orderlist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gm Orderlist', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'playerid',
            'orderid',
            'productid',
            'reward',
            // 'source',
            // 'fee',
            // 'transaction_id',
            // 'transaction_time',
            // 'status',
            // 'ctime',
            // 'utime',
            // 'vipcard_g',
            // 'vipcard_s',
            // 'vipcard_c',
            // 'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
