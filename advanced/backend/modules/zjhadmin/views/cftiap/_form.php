<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgIpayParams */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-ipay-params-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'appdesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'appid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'privatekey')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'platkey')->textarea(['rows' => 6]) ?>
 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
