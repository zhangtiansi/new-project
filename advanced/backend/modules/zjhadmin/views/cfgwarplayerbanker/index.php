<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgWarPlayerBankerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cfg War Player Bankers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-war-player-banker-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cfg War Player Banker', ['create'], ['class' => 'btn btn-success']) ?>
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
