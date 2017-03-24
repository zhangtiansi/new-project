<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogActrewards */

$this->title = 'Create Log Actrewards';
$this->params['breadcrumbs'][] = ['label' => 'Log Actrewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-actrewards-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
