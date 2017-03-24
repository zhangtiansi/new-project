<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataDailyStay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-daily-stay-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'udate')->textInput() ?>

    <?= $form->field($model, 'channel')->textInput() ?>

    <?= $form->field($model, 'stay2')->textInput() ?>

    <?= $form->field($model, 'activestay2')->textInput() ?>

    <?= $form->field($model, 'paystay2')->textInput() ?>

    <?= $form->field($model, 'stay3')->textInput() ?>

    <?= $form->field($model, 'activestay3')->textInput() ?>

    <?= $form->field($model, 'paystay3')->textInput() ?>

    <?= $form->field($model, 'stay7')->textInput() ?>

    <?= $form->field($model, 'activestay7')->textInput() ?>

    <?= $form->field($model, 'paystay7')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
