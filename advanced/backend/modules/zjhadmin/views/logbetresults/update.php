<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogBetResults */

$this->title = 'Update Log Bet Results: ' . ' ' . $model->bid;
$this->params['breadcrumbs'][] = ['label' => 'Log Bet Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bid, 'url' => ['view', 'id' => $model->bid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-bet-results-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
