<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogMaxAlldaily */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-max-alldaily-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gid')->textInput() ?>

    <?= $form->field($model, 'maxCoin')->textInput() ?>

    <?= $form->field($model, 'maxType')->textInput() ?>

    <?= $form->field($model, 'minType')->textInput() ?>

    <?= $form->field($model, 'minCoin')->textInput() ?>

    <?= $form->field($model, 'totalchange')->textInput() ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
