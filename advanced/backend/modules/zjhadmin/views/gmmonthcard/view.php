<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GmMonthCard */

$this->title = $model->gid;
$this->params['breadcrumbs'][] = ['label' => 'Gm Month Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-month-card-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->gid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->gid], [
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
            'gid',
            'firstbg_tm',
            'buy_tm',
            'lastbuy_tm',
            'lastget_tm',
        ],
    ]) ?>

</div>
