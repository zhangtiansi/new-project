<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogCoinHistory */

$this->title = 'Update Log Coin History: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Coin Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-coin-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
