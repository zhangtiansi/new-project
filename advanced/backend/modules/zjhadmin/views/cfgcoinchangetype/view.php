<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cfgcoinchangetype */

$this->title = $model->cid;
$this->params['breadcrumbs'][] = ['label' => 'Cfgcoinchangetypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfgcoinchangetype-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cid], [
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
            'cid',
            'c_name',
            'c_desc',
            'ctime',
        ],
    ]) ?>

</div>
