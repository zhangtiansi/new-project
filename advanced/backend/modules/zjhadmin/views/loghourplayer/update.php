<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogHourPlayerinfo */

$this->title = 'Update Log Hour Playerinfo: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Log Hour Playerinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->gid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-hour-playerinfo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
