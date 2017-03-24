<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogMaxAlldailySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-max-alldaily-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gid') ?>

    <?= $form->field($model, 'maxCoin') ?>

    <?= $form->field($model, 'maxType') ?>

    <?= $form->field($model, 'minType') ?>

    <?php // echo $form->field($model, 'minCoin') ?>

    <?php // echo $form->field($model, 'totalchange') ?>

    <?php // echo $form->field($model, 'ctime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
