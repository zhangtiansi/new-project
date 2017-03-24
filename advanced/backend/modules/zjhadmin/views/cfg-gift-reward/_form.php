<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgGiftReward */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-gift-reward-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reward_name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'chance')->textInput() ?>

    <?= $form->field($model, 'threshold')->textInput() ?>

    <?= $form->field($model, 'coin_pool')->textInput() ?>

    <?= $form->field($model, 'reward')->textInput() ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <?= $form->field($model, 'gift_id')->textInput() ?>

    <?= $form->field($model, 'gfit_name')->textInput(['maxlength' => 11]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
