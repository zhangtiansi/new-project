<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmNotice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-notice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
 
    <?= $form->field($model, 'tag')->dropDownList([0=>'热门',1=>'新增',2=>'限时']);?>

    <?= $form->field($model, 'type')->dropDownList([0=>'公告',1=>'活动']);?> 

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'content_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tips')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'utime')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([0=>'生效',1=>'失效']);?>  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
