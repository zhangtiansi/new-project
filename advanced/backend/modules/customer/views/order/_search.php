<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmOrderlistSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-orderlist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'playerid') ?>

    <?= $form->field($model, 'orderid') ?>

    <?= $form->field($model, 'productid') ?>

    <?= $form->field($model, 'reward') ?>

    <?php // echo $form->field($model, 'source') ?>

    <?php // echo $form->field($model, 'fee') ?>

    <?php // echo $form->field($model, 'transaction_id') ?>

    <?php // echo $form->field($model, 'transaction_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'ctime') ?>

    <?php // echo $form->field($model, 'utime') ?>

    <?php // echo $form->field($model, 'vipcard_g') ?>

    <?php // echo $form->field($model, 'vipcard_s') ?>

    <?php // echo $form->field($model, 'vipcard_c') ?>

    <?php // echo $form->field($model, 'price') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
