<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogSyserror */

$this->title = 'Create Log Syserror';
$this->params['breadcrumbs'][] = ['label' => 'Log Syserrors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-syserror-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
