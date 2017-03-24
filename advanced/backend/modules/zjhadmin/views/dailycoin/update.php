<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DataDailyCoinchange */

$this->title = 'Update Data Daily Coinchange: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Daily Coinchanges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-daily-coinchange-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
