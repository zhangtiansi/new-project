<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogMaxAlldailySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Max Alldailies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-max-alldaily-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log Max Alldaily', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'gid',
            'maxCoin',
            'maxType',
            'minType',
            // 'minCoin',
            // 'totalchange',
            // 'ctime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
