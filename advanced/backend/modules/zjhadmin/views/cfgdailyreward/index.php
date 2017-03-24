<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgDailyRewardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cfg Daily Rewards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-daily-reward-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cfg Daily Reward', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'day_num',
            'reward',
            'ctime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
