<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gm Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-activity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gm Activity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'activity_name',
            'activity_desc',
            'activity_begin',
            'activity_end',
            'status',
            'activity_type',
            'total_fee',
            'reward_coin',
            'card_g',
            'card_s',
            'card_c',
            'utime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
