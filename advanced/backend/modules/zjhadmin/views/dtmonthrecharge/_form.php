<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataMonthRecharge */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-month-recharge-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'c_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'channel')->textInput() ?>

    <?= $form->field($model, 'pay_source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recharge')->textInput() ?>

    <?= $form->field($model, 'num')->textInput() ?>

    <?= $form->field($model, 'unum')->textInput() ?>

    <?= $form->field($model, 'arpu')->textInput() ?>

    <?= $form->field($model, 'pay_avg')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
