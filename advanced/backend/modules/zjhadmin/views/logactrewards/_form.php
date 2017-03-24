<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogActrewards */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-actrewards-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gid')->textInput() ?>

    <?= $form->field($model, 'point')->textInput() ?>

    <?= $form->field($model, 'coin')->textInput() ?>

    <?= $form->field($model, 'propid')->textInput() ?>

    <?= $form->field($model, 'propnum')->textInput() ?>

    <?= $form->field($model, 'card_g')->textInput() ?>

    <?= $form->field($model, 'card_s')->textInput() ?>

    <?= $form->field($model, 'card_c')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <?= $form->field($model, 'change_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
