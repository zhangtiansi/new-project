<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DataMonthRechargeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Month Recharges';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-month-recharge-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Data Month Recharge', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'c_month',
            'channel',
            'pay_source',
            'recharge',
            // 'num',
            // 'unum',
            // 'arpu',
            // 'pay_avg',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
