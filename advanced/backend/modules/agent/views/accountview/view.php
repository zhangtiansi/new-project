<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GmAccountInfo */

$this->title = $model->gid;
$this->params['breadcrumbs'][] = ['label' => 'Gm Account Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-account-info-view">

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
            'account_name',
            'account_pwd',
            'pwd_q',
            'pwd_a',
            'sim_serial',
            'device_id',
            'op_uuid',
            'type',
            'reg_channel',
            'reg_time',
            'last_login',
            'token',
            'status',
        ],
    ]) ?>

</div>
