<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgCoinPrice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-coin-price-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'p_name')->textInput() ?>

    <?= $form->field($model, 'p_coin')->textInput() ?>

    <?= $form->field($model, 'p_cost')->textInput() ?>

    <?= $form->field($model, 'p_desc')->textInput() ?>

    <?= $form->field($model, 'utime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
