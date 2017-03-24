<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogHourPlayerinfo */

$this->title = 'Create Log Hour Playerinfo';
$this->params['breadcrumbs'][] = ['label' => 'Log Hour Playerinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-hour-playerinfo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
