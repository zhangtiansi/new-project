<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogCoinRecordsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-coin-records-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'from_uid') ?>

    <?= $form->field($model, 'change_type') ?>

    <?= $form->field($model, 'change_before') ?>

    <?php // echo $form->field($model, 'change_coin') ?>

    <?php // echo $form->field($model, 'change_after') ?>

    <?php // echo $form->field($model, 'game_no') ?>

    <?php // echo $form->field($model, 'prop_id') ?>

    <?php // echo $form->field($model, 'ctime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
