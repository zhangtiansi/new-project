<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataChannelUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-channel-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'udate')->textInput() ?>

    <?= $form->field($model, 'channel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activenum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'regactive')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
