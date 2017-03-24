<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataMonthRechargeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-month-recharge-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'c_month') ?>

    <?= $form->field($model, 'channel') ?>

    <?= $form->field($model, 'pay_source') ?>

    <?= $form->field($model, 'recharge') ?>

    <?php // echo $form->field($model, 'num') ?>

    <?php // echo $form->field($model, 'unum') ?>

    <?php // echo $form->field($model, 'arpu') ?>

    <?php // echo $form->field($model, 'pay_avg') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
