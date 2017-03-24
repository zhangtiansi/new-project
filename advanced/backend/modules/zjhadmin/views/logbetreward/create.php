<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogBetReward */

$this->title = 'Create Log Bet Reward';
$this->params['breadcrumbs'][] = ['label' => 'Log Bet Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-bet-reward-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
