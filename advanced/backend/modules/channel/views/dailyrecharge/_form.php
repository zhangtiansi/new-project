<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataDailyRecharge */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-daily-recharge-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'udate')->textInput() ?>

    <?= $form->field($model, 'channel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'totalfee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pnum')->textInput() ?>

    <?= $form->field($model, 'ptime')->textInput() ?>

    <?= $form->field($model, 'up')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avg')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
