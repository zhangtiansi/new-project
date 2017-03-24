<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogGift */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-gift-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from_uid')->textInput() ?>

    <?= $form->field($model, 'to_uid')->textInput() ?>

    <?= $form->field($model, 'gift_id')->textInput() ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
