<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\GmChannelInfo;

/* @var $this yii\web\View */
/* @var $model app\models\GmAccountInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="toprecharge">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gid') ?>
    <?= $form->field($model, 'name') ?> 
     <?= $form->field($model, 'reg_channel')->dropDownList(GmChannelInfo::getChannelDropList()); ?>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
