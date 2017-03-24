<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgProps */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-props-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prop_name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'prop_cost')->textInput() ?>

    <?= $form->field($model, 'cost_type')->textInput() ?>

    <?= $form->field($model, 'utime')->textInput() ?>

    <?= $form->field($model, 'prop_type')->textInput() ?>

    <?= $form->field($model, 'charm')->textInput() ?>

    <?= $form->field($model, 'change')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
