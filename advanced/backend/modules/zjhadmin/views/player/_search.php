<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmPlayerInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-player-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'account_id') ?>

    <?php // $form->field($model, 'partner_id') ?>

    <?= $form->field($model, 'name') ?>

    <?php // $form->field($model, 'account') ?>

    <?php // $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'point') ?>

    <?php // echo $form->field($model, 'money') ?>

    <?php // echo $form->field($model, 'last_login') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'power') ?>

    <?php // echo $form->field($model, 'charm') ?>

    <?php // echo $form->field($model, 'exploit') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'icon') ?>

    <?php // echo $form->field($model, 'point_box') ?>

    <?php // echo $form->field($model, 'point_pwd') ?>

    <?php // echo $form->field($model, 'max_win') ?>

    <?php // echo $form->field($model, 'sign') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'avatar64') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
