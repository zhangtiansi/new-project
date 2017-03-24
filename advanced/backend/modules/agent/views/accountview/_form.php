<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmAccountInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-account-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'account_name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'account_pwd')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'pwd_q')->textInput() ?>

    <?= $form->field($model, 'pwd_a')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'sim_serial')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'device_id')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'op_uuid')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'reg_channel')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'reg_time')->textInput() ?>

    <?= $form->field($model, 'last_login')->textInput() ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
