<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogWarResult */

$this->title = $model->war_id;
$this->params['breadcrumbs'][] = ['label' => 'Log War Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-war-result-view">

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
            'men_1',
            'men_2',
            'men_3',
            'men_4',
            'men_card_1',
            'men_card_2',
            'men_card_3',
            'men_card_4',
            'ctme',
            'banker',
            'banker_card',
        ],
    ]) ?>

</div>
