<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CfgWarconfig */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cfg Warconfigs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-warconfig-view">

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
            'di_coin',
            'shang_coin',
            'xia_coin',
            'seat_coin',
            'xia_turn',
            'ya_shui',
            'war_id',
            'stime:datetime',
            'robot_coin',
            'war_open',
            'max_coin',
            'seat_coin_min',
            'prize_shui',
            'prize_coin',
            'prize_coin_max',
            'prize_name_max',
            'card_1',
            'card_2',
            'card_3',
            'card_type_1',
            'card_type_2',
            'card_type_3',
        ],
    ]) ?>

</div>
