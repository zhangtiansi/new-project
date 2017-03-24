<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GmOptact */

$this->title = 'Update Gm Optact: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Gm Optacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gm-optact-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
