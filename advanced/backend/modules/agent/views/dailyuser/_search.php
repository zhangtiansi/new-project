<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataDailyUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-daily-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'udate') ?>

    <?= $form->field($model, 'channel') ?>

    <?= $form->field($model, 'totalreg') ?>

    <?= $form->field($model, 'loginp') ?>

    <?php // echo $form->field($model, 'loginnum') ?>

    <?php // echo $form->field($model, 'activenum') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
