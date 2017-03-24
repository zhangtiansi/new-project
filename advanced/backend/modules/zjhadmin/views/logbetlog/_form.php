<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogBetlog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-betlog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'account_id')->textInput() ?>

    <?= $form->field($model, 'bet_1')->textInput() ?>

    <?= $form->field($model, 'bet_2')->textInput() ?>

    <?= $form->field($model, 'bet_3')->textInput() ?>

    <?= $form->field($model, 'bet_4')->textInput() ?>

    <?= $form->field($model, 'bet_5')->textInput() ?>

    <?= $form->field($model, 'bet_6')->textInput() ?>

    <?= $form->field($model, 'mark')->textInput() ?>

    <?= $form->field($model, 'bid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
