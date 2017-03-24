<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogWarResult */

$this->title = 'Update Log War Result: ' . ' ' . $model->war_id;
$this->params['breadcrumbs'][] = ['label' => 'Log War Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->war_id, 'url' => ['view', 'id' => $model->war_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-war-result-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
