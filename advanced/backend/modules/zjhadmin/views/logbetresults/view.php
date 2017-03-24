<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogBetResults */

$this->title = $model->bid;
$this->params['breadcrumbs'][] = ['label' => 'Log Bet Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-bet-results-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->bid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->bid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'bid',
            'result',
            'ctime',
            'coin',
            'player_num',
        ],
    ]) ?>

</div>
