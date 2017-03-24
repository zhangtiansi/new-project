<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogCoinRecords */

$this->title = 'Create Log Coin Records';
$this->params['breadcrumbs'][] = ['label' => 'Log Coin Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-coin-records-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
