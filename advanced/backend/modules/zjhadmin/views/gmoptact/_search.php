<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmOptactSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-optact-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'act_title') ?>

    <?= $form->field($model, 'act_desc') ?>

    <?= $form->field($model, 'act_type') ?>

    <?php // echo $form->field($model, 'begin_tm') ?>

    <?php // echo $form->field($model, 'end_tm') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
