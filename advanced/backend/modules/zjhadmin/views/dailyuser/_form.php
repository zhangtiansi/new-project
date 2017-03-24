<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataDailyUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-daily-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'udate')->textInput() ?>

    <?= $form->field($model, 'channel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'totalreg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'loginp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'loginnum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activenum')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
