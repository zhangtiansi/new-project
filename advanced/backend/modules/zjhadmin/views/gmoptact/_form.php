<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmOptact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-optact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'act_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'act_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'act_type')->dropDownList([
        1=>'不可选',
        2=>'充值满送',
        3=>'ios满送活动',
        4=>'每日登录即送活动',
        5=>'时时乐排名',
        6=>'每日充值单笔6元礼包',
        7=>'特殊牌型',
        8=>'vip送礼',
        9=>'首充指定金额',
        10=>'充值指定金额必送',
        11=>'水浒传指定次数',
        12=>'百人赢四门',
        13=>'普通游戏场满N场送N万9点',
        14=>'时时乐累积押注超过N万次日送N万10点',
        15=>'首日充值满N元次日送N万金币9.30',
        16=>'百人押注排行榜9.30',
        17=>'百人坐庄排行榜9.30',
        18=>'百人盈利排行榜9.30',
    ]) ?>

    <?= $form->field($model, 'begin_tm')->textInput() ?>

    <?= $form->field($model, 'end_tm')->textInput() ?>
    <?= $form->field($model, 'standard')->textInput() ?>
    <?= $form->field($model, 'diamond')->textInput() ?>
    <?= $form->field($model, 'coin')->textInput() ?>
    <?= $form->field($model, 'propid')->textInput() ?>
    <?= $form->field($model, 'propnum')->textInput() ?>
    <?= $form->field($model, 'vcard_g')->textInput() ?>
    <?= $form->field($model, 'vcard_s')->textInput() ?>
    <?= $form->field($model, 'vcard_c')->textInput() ?>
    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
