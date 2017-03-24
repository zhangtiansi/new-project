<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgVipLevelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cfg Vip Levels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-vip-level-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cfg Vip Level', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'vip_level',
            'vip_exp',
            'vip_reward',
            'ctime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
