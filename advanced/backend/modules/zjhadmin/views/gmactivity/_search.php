<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmActivitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-activity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'activity_name') ?>

    <?= $form->field($model, 'activity_desc') ?>

    <?= $form->field($model, 'activity_begin') ?>

    <?= $form->field($model, 'activity_end') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'activity_type') ?>

    <?php // echo $form->field($model, 'total_fee') ?>

    <?php // echo $form->field($model, 'reward_coin') ?>

    <?php // echo $form->field($model, 'card_g') ?>

    <?php // echo $form->field($model, 'card_s') ?>

    <?php // echo $form->field($model, 'card_c') ?>

    <?php // echo $form->field($model, 'utime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
