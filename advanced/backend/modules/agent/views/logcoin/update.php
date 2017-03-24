<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogCoinRecords */

$this->title = 'Update Log Coin Records: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Coin Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-coin-records-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
