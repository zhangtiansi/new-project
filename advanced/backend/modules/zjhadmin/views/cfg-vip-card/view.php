<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CfgVipCard */

$this->title = $model->card_id;
$this->params['breadcrumbs'][] = ['label' => 'Cfg Vip Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-vip-card-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->card_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->card_id], [
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
            'card_id',
            'card_name',
            'card_exp',
            'card_cost',
            'ctime',
        ],
    ]) ?>

</div>
