<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\GmChannelInfo;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DailystaySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dailystay-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'udate') ?>

    <?= $form->field($model, 'channel')->dropDownList(GmChannelInfo::getChannelDropList()); ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
