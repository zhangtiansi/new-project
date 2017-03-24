<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogMaxDicechange */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-max-dicechange-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gid')->textInput() ?>

    <?= $form->field($model, 'coin')->textInput() ?>

    <?= $form->field($model, 'totalbet')->textInput() ?>

    <?= $form->field($model, 'totalwin')->textInput() ?>

    <?= $form->field($model, 'totalchange')->textInput() ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <?= $form->field($model, 'play_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
