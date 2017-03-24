<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\LogBetResults;

/* @var $this yii\web\View */
/* @var $model app\models\LogBetRewardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-bet-reward-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bid') ?>

    <?= $form->field($model, 'bettype')->dropDownList(array_merge([0=>"不限"],LogBetResults::$px));?>

    <?= $form->field($model, 'gid') ?>

    <?= $form->field($model, 'reward') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
