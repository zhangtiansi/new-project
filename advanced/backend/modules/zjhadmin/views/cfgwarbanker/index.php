<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgWarBankerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cfg War Bankers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-war-banker-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cfg War Banker', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'men_1',
            'men_2',
            'men_3',
            'men_4',
            // 'men_5',
            // 'b_open',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
