<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GmActivity */

$this->title = 'Update Gm Activity: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gm Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gm-activity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
