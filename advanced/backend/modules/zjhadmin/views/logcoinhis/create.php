<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogCoinHistory */

$this->title = 'Create Log Coin History';
$this->params['breadcrumbs'][] = ['label' => 'Log Coin Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-coin-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
