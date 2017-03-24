<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataDailyCoinchange */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-daily-coinchange-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'udate')->textInput() ?>

    <?= $form->field($model, 'change_type')->textInput() ?>

    <?= $form->field($model, 'sum_coin')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
