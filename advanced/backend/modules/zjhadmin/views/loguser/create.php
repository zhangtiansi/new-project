<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogUserrequst */

$this->title = 'Create Log Userrequst';
$this->params['breadcrumbs'][] = ['label' => 'Log Userrequsts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-userrequst-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
