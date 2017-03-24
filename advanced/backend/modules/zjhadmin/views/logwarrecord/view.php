<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogWarRecord */

$this->title = $model->war_id;
$this->params['breadcrumbs'][] = ['label' => 'Log War Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-war-record-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->war_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->war_id], [
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
            'war_id',
            'men1_coin',
            'men1_prize',
            'men2_coin',
            'men2_prize',
            'men3_coin',
            'men3_prize',
            'men4_coin',
            'men4_prize',
            'banker_id',
            'banker_coin',
            'ctime',
        ],
    ]) ?>

</div>
