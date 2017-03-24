<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmAccountInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coin-game-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gid') ?>

    <?php echo $form->field($model, 'ctime') ?>
    <?php //echo $form->field($model, 'account_name') ?>
    <?php //echo $form->field($model, 'name') ?>
    <?php //echo $form->field($model, 'ime') ?>

    <?php // echo $form->field($model, 'sim_serial') ?>

    <?php // echo $form->field($model, 'device_id') ?>

    <?php // echo $form->field($model, 'op_uuid') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'reg_channel') ?>

    <?php // echo $form->field($model, 'reg_time') ?>

    <?php // echo $form->field($model, 'last_login') ?>

    <?php // echo $form->field($model, 'token') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
