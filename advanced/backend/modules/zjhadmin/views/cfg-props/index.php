<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgPropsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cfg Props';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-props-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cfg Props', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'prop_name',
            'prop_cost',
            'cost_type',
            'utime',
            'prop_type',
            'charm',
            'change',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
