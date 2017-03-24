<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogMaxGamechange */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Max Gamechanges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-max-gamechange-view">

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
            'coin',
            'totalchange',
            'ctime',
            'play_time:datetime',
        ],
    ]) ?>

</div>
