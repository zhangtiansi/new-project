<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\GmChannelInfo;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DataDailyUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-daily-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'udate') ?>

     <?= $form->field($model, 'channel')->dropDownList(GmChannelInfo::getChannelDropList()); ?>
<!--     --><?//= $form->field($model, 'channelname'); ?>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
