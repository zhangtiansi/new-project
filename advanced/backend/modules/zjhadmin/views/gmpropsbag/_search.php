<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmpropsbagSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-props-bag-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'account_id') ?>

    <?= $form->field($model, 'item_id') ?>

    <?= $form->field($model, 'item_num') ?>

    <?= $form->field($model, 'exp') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'ctime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
