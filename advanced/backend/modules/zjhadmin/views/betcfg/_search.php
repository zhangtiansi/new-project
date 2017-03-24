<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgBetconfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-betconfig-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'min_num') ?>

    <?= $form->field($model, 'max_num') ?>

    <?= $form->field($model, 'ntime') ?>

    <?= $form->field($model, 'num_yu') ?>

    <?php // echo $form->field($model, 'num_coin') ?>

    <?php // echo $form->field($model, 'bidnow') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
