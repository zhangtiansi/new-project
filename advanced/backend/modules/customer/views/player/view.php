<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GmPlayerInfo */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Gm Player Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-player-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->account_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->account_id], [
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
            'account_id',
            'partner_id',
            'name',
            'account',
            'sex',
            'point',
            'money',
            'last_login',
            'level',
            'power',
            'charm',
            'exploit',
            'create_time:datetime',
            'status',
            'icon',
            'point_box',
            'point_pwd',
            'max_win',
            'sign',
            'tel',
            'avatar64:ntext',
        ],
    ]) ?>

</div>
