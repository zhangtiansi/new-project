<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogBanlogs */

$this->title = 'Create Log Banlogs';
$this->params['breadcrumbs'][] = ['label' => 'Log Banlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-banlogs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
