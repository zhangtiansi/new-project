<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogBetReward */

$this->title = 'Update Log Bet Reward: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Bet Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-bet-reward-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
