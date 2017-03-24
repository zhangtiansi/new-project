<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgBetconfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-betconfig-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'min_num')->textInput() ?>

    <?= $form->field($model, 'max_num')->textInput() ?>

    <?= $form->field($model, 'ntime')->textInput() ?>

    <?= $form->field($model, 'num_yu')->textInput() ?>

    <?= $form->field($model, 'num_coin')->textInput() ?>

    <?= $form->field($model, 'bidnow')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
