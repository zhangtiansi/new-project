<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogWarResult */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-war-result-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'war_id')->textInput() ?>

    <?= $form->field($model, 'men_1')->textInput() ?>

    <?= $form->field($model, 'men_2')->textInput() ?>

    <?= $form->field($model, 'men_3')->textInput() ?>

    <?= $form->field($model, 'men_4')->textInput() ?>

    <?= $form->field($model, 'men_card_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'men_card_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'men_card_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'men_card_4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ctme')->textInput() ?>

    <?= $form->field($model, 'banker')->textInput() ?>

    <?= $form->field($model, 'banker_card')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
