<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogWarRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-war-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'war_id')->textInput() ?>

    <?= $form->field($model, 'men1_coin')->textInput() ?>

    <?= $form->field($model, 'men1_prize')->textInput() ?>

    <?= $form->field($model, 'men2_coin')->textInput() ?>

    <?= $form->field($model, 'men2_prize')->textInput() ?>

    <?= $form->field($model, 'men3_coin')->textInput() ?>

    <?= $form->field($model, 'men3_prize')->textInput() ?>

    <?= $form->field($model, 'men4_coin')->textInput() ?>

    <?= $form->field($model, 'men4_prize')->textInput() ?>

    <?= $form->field($model, 'banker_id')->textInput() ?>

    <?= $form->field($model, 'banker_coin')->textInput() ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
