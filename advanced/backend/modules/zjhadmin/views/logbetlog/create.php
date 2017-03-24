<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogBetlog */

$this->title = 'Create Log Betlog';
$this->params['breadcrumbs'][] = ['label' => 'Log Betlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-betlog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
