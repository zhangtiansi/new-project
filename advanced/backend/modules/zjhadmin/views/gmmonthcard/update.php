<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GmMonthCard */

$this->title = 'Update Gm Month Card: ' . ' ' . $model->gid;
$this->params['breadcrumbs'][] = ['label' => 'Gm Month Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gid, 'url' => ['view', 'id' => $model->gid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gm-month-card-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
