<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmpropsbagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gm Props Bags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-props-bag-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gm Props Bag', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'account_id',
            'item_id',
            'item_num',
            'exp',
            'name',
            'type',
            'ctime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
