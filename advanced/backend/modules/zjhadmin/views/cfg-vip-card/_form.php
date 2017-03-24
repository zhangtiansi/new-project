<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgVipCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-vip-card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'card_name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'card_exp')->textInput() ?>

    <?= $form->field($model, 'card_cost')->textInput() ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
