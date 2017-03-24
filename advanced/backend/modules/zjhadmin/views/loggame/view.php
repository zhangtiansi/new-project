<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogCoinRecords */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Coin Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-coin-records-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'uid',
            'from_uid',
            'change_type',
            'change_before',
            'change_coin',
            'change_after',
            'game_no',
            'prop_id',
            'ctime',
        ],
    ]) ?>

</div>
