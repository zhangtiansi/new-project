<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\CfgProps;
use app\models\GmChannelInfo;

/* @var $this yii\web\View */
/* @var $model app\models\LogUserrequstSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-userrequst-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'gid') ?>
    <?php echo $form->field($model, 'simSerial') ?>
    <?php echo $form->field($model, 'dev_id') ?>
     <?= $form->field($model, 'channel')->dropDownList(GmChannelInfo::getChannelDropList()); ?>
     <?php  echo $form->field($model, 'request_ip') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
