<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogUserrequst */

$this->title = 'Update Log Userrequst: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Userrequsts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-userrequst-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
