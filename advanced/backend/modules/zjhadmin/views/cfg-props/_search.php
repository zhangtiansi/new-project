<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgPropsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-props-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'prop_name') ?>

    <?= $form->field($model, 'prop_cost') ?>

    <?= $form->field($model, 'cost_type') ?>

    <?= $form->field($model, 'utime') ?>

    <?php // echo $form->field($model, 'prop_type') ?>

    <?php // echo $form->field($model, 'charm') ?>

    <?php // echo $form->field($model, 'change') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
