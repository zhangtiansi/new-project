<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogUserrequstSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-userrequst-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'gid') ?>

    <?= $form->field($model, 'keyword') ?>

    <?= $form->field($model, 'osver') ?>

    <?= $form->field($model, 'appver') ?>

    <?php  echo $form->field($model, 'lineNo') ?>

    <?php  echo $form->field($model, 'uuid') ?>

    <?php echo $form->field($model, 'simSerial') ?>

    <?php echo $form->field($model, 'dev_id') ?>

    <?php // echo $form->field($model, 'channel') ?>

    <?php // echo $form->field($model, 'ctime') ?>

    <?php  echo $form->field($model, 'request_ip') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
