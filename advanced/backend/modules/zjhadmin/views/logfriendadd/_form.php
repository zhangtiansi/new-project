<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogFriendadd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-friendadd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'aid_from')->textInput() ?>

    <?= $form->field($model, 'from_name')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'aid_to')->textInput() ?>

    <?= $form->field($model, 'to_name')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'mark')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
