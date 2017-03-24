<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogBetReward */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-bet-reward-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bid')->textInput() ?>

    <?= $form->field($model, 'bettype')->textInput() ?>

    <?= $form->field($model, 'gid')->textInput() ?>

    <?= $form->field($model, 'reward')->textInput() ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
