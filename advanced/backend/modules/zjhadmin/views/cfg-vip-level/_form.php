<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgVipLevel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-vip-level-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vip_exp')->textInput() ?>

    <?= $form->field($model, 'vip_reward')->textInput() ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
