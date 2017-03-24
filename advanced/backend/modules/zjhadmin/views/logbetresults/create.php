<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogBetResults */

$this->title = 'Create Log Bet Results';
$this->params['breadcrumbs'][] = ['label' => 'Log Bet Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-bet-results-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
