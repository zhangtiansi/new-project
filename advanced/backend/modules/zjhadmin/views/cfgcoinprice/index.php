<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgCoinPriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cfg Coin Prices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-coin-price-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cfg Coin Price', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'p_name',
            'p_coin',
            'p_cost',
            'p_desc',
            'utime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
