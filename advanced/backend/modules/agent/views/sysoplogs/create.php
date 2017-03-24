<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SysOplogs */

$this->title = 'Create Sys Oplogs';
$this->params['breadcrumbs'][] = ['label' => 'Sys Oplogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-oplogs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
