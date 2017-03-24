<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogBanlogs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-banlogs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gid')->textInput() ?>

    <?= $form->field($model, 'ban_time')->textInput() ?>

    <?= $form->field($model, 'ban_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ban_type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
