<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogGift */

$this->title = 'Update Log Gift: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-gift-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
