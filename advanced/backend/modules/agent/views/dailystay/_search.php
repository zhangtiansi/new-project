<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataDailyStaySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-daily-stay-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'udate') ?>

    <?= $form->field($model, 'channel') ?>

    <?= $form->field($model, 'stay2') ?>

    <?= $form->field($model, 'activestay2') ?>

    <?php // echo $form->field($model, 'paystay2') ?>

    <?php // echo $form->field($model, 'stay3') ?>

    <?php // echo $form->field($model, 'activestay3') ?>

    <?php // echo $form->field($model, 'paystay3') ?>

    <?php // echo $form->field($model, 'stay7') ?>

    <?php // echo $form->field($model, 'activestay7') ?>

    <?php // echo $form->field($model, 'paystay7') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
