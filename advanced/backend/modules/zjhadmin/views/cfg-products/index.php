<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cfg Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-products-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cfg Products', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'product_name',
            'product_desc',
            'price',
            'diamonds',
            'vipcard_g',
            'vipcard_s',
            'vipcard_c',
            'utime',
            'product_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
