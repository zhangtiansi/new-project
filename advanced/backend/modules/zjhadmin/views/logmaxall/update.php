<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogMaxAlldaily */

$this->title = 'Update Log Max Alldaily: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Max Alldailies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-max-alldaily-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
