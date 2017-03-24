<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgWarPlayerBanker */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-war-player-banker-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'men_1')->textInput() ?>

    <?= $form->field($model, 'men_2')->textInput() ?>

    <?= $form->field($model, 'men_3')->textInput() ?>

    <?= $form->field($model, 'men_4')->textInput() ?>

    <?= $form->field($model, 'men_5')->textInput() ?>

    <?= $form->field($model, 'b_open')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
