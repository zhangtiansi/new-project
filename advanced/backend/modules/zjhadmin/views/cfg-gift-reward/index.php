<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgGiftRewardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cfg Gift Rewards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-gift-reward-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cfg Gift Reward', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'reward_name',
            'chance',
            'threshold',
            'coin_pool',
            'reward',
            'ctime',
            'gift_id',
            'gfit_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
