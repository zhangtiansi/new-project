<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GmOptact */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Gm Optacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-optact-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('克隆', ['create', 'c' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'act_title',
            'act_desc',
            ['attribute'=>'act_type',
              'value'=>$model->act_type==2?"充值满送":$model->act_type,
            ],
            'act_type',
            'begin_tm',
            'end_tm',
            'standard',
            'diamond',
            'coin',
            'propid',
            'propnum',
            'vcard_g',
            'vcard_s',
            'vcard_c',
            'status',
        ],
    ]) ?>

</div>
