<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgWarBankerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-war-banker-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'men_1') ?>

    <?= $form->field($model, 'men_2') ?>

    <?= $form->field($model, 'men_3') ?>

    <?= $form->field($model, 'men_4') ?>

    <?php // echo $form->field($model, 'men_5') ?>

    <?php // echo $form->field($model, 'b_open') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
