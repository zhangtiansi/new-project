<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dailystay */

$this->title = 'Update Dailystay: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dailystays', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dailystay-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
