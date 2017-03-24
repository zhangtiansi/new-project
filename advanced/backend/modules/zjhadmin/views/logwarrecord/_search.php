<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogWarRecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-war-record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'war_id') ?>

    <?php // echo $form->field($model, 'men3_coin') ?>

    <?php // echo $form->field($model, 'men3_prize') ?>

    <?php // echo $form->field($model, 'men4_coin') ?>

    <?php // echo $form->field($model, 'men4_prize') ?>

    <?php  echo $form->field($model, 'banker_id') ?>

    <?php // echo $form->field($model, 'banker_coin') ?>

    <?php  echo $form->field($model, 'ctime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
