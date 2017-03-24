<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SysOplogsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-oplogs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'opid') ?>

    <?= $form->field($model, 'keyword') ?>

    <?= $form->field($model, 'cid') ?>

    <?= $form->field($model, 'gid') ?>

    <?php // echo $form->field($model, 'logs') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'ctime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
