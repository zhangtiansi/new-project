<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgProducts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'product_desc')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'diamonds')->textInput() ?>

    <?= $form->field($model, 'vipcard_g')->textInput() ?>

    <?= $form->field($model, 'vipcard_s')->textInput() ?>

    <?= $form->field($model, 'vipcard_c')->textInput() ?>

    <?= $form->field($model, 'utime')->textInput() ?>

    <?= $form->field($model, 'product_type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
