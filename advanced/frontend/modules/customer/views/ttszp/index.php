<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TtszpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ttszps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttszp-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'buyer',
            'order',
            'payment',
            'money',
            'goods',
            'ctime',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
