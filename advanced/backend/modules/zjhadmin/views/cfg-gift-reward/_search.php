<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgGiftRewardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-gift-reward-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'reward_name') ?>

    <?= $form->field($model, 'chance') ?>

    <?= $form->field($model, 'threshold') ?>

    <?= $form->field($model, 'coin_pool') ?>

    <?php // echo $form->field($model, 'reward') ?>

    <?php // echo $form->field($model, 'ctime') ?>

    <?php // echo $form->field($model, 'gift_id') ?>

    <?php // echo $form->field($model, 'gfit_name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
