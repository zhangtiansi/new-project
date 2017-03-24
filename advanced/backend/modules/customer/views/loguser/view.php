<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogUserrequst */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Userrequsts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-userrequst-view">

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
            'gid',
            'keyword',
            'osver',
            'appver',
            'lineNo',
            'uuid',
            'simSerial',
            'dev_id',
            'channel',
            'ctime',
            'request_ip',
        ],
    ]) ?>

</div>
