<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmChannelInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-channel-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cid') ?>

    <?= $form->field($model, 'channel_name') ?>

    <?= $form->field($model, 'channel_desc') ?>

    <?= $form->field($model, 'opname') ?>

    <?= $form->field($model, 'oppasswd') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'cur_version') ?>

    <?php // echo $form->field($model, 'update_url') ?>

    <?php // echo $form->field($model, 'version_code') ?>

    <?php // echo $form->field($model, 'changelog') ?>

    <?php // echo $form->field($model, 'force') ?>

    <?php // echo $form->field($model, 'ctime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
