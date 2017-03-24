<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgPwdQa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-pwd-qa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'q_content')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
