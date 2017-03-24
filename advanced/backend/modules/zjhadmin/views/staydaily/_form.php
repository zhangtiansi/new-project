<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dailystay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dailystay-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'udate')->textInput() ?>

    <?= $form->field($model, 'channel')->textInput() ?>

    <?= $form->field($model, 'r_num')->textInput() ?>

    <?= $form->field($model, 's_num2')->textInput() ?>

    <?= $form->field($model, 's_num3')->textInput() ?>

    <?= $form->field($model, 's_num7')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
