<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\GmChannelInfo;

/* @var $this yii\web\View */
/* @var $model app\models\DataMonthRechargeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-month-recharge-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'c_month') ?>

     <?= $form->field($model, 'channel')->dropDownList(GmChannelInfo::getChannelDropList()); ?>

    <?= $form->field($model, 'pay_source') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
