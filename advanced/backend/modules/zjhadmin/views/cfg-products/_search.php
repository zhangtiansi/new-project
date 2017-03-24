<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-products-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'product_name') ?>

    <?= $form->field($model, 'product_desc') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'diamonds') ?>

    <?php // echo $form->field($model, 'vipcard_g') ?>

    <?php // echo $form->field($model, 'vipcard_s') ?>

    <?php // echo $form->field($model, 'vipcard_c') ?>

    <?php // echo $form->field($model, 'utime') ?>

    <?php // echo $form->field($model, 'product_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
