<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GmOrderlist */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gm Orderlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-orderlist-view">

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
            'playerid',
            'orderid',
            'productid',
            'reward',
            'source',
            'fee',
            'transaction_id',
            'transaction_time',
            'status',
            'ctime',
            'utime',
            'vipcard_g',
            'vipcard_s',
            'vipcard_c',
            'price',
        ],
    ]) ?>

</div>
