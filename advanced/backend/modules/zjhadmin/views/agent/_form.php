<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AgentInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agent-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelacc, 'username')->textInput($model->isNewRecord ?[]:['readonly'=>true])?>
    
    <?php
        if ($model->isNewRecord){
            echo $form->field($modelacc, 'password_hash')->textInput();
        }else{
            echo $form->field($modelacc, 'newpasswd')->textInput();
        }?>
    
    <?php echo $model->isNewRecord ?"":$form->field($modelacc, 'status')->dropDownList(['正常','禁止登录'])?>
        
    <?= $form->field($model, 'agent_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'money')->textInput($model->isNewRecord ?[]:['readonly'=>true]) ?>

    <?= $form->field($model, 'agent_desc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
