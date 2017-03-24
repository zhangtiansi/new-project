<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'activity_name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'activity_desc')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'activity_begin')->textInput() ?>

    <?= $form->field($model, 'activity_end')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'activity_type')->textInput() ?>

    <?= $form->field($model, 'total_fee')->textInput() ?>

    <?= $form->field($model, 'reward_coin')->textInput() ?>

    <?= $form->field($model, 'card_g')->textInput() ?>

    <?= $form->field($model, 'card_s')->textInput() ?>

    <?= $form->field($model, 'card_c')->textInput() ?>

    <?= $form->field($model, 'utime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
