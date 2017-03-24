<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogCoinRecords */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-coin-records-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <?= $form->field($model, 'from_uid')->textInput() ?>

    <?= $form->field($model, 'change_type')->textInput() ?>

    <?= $form->field($model, 'change_before')->textInput() ?>

    <?= $form->field($model, 'change_coin')->textInput() ?>

    <?= $form->field($model, 'change_after')->textInput() ?>

    <?= $form->field($model, 'game_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prop_id')->textInput() ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
