<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CfgIpayParams;

/* @var $this yii\web\View */
/* @var $model app\models\GmChannelInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-channel-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'channel_name')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'channel_desc')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'any_channel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelacc, 'username')->textInput(['maxlength' => true]) ?>

    <?php
        if ($modelacc->isNewRecord){
            echo $form->field($modelacc, 'password_hash')->textInput();
            echo $form->field($modelacc, 'newpasswd')->textInput(['display'=>'none']);
        }else{
            echo $form->field($modelacc, 'newpasswd')->textInput();
        }?>

    <?php echo $model->isNewRecord ?"":$form->field($modelacc, 'status')->dropDownList(['正常','禁止登录'])?>
    
    <?= $form->field($modelacc, 'role')->dropDownList([5=>'CPS渠道',6=>'CPA渠道']);?>
    
    <?= $form->field($model, 'p_user')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'p_recharge')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'p_gm')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'cur_version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_url')->textInput(['maxlength' => true]) ?> 
    <?= $form->field($model, 'changelog')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'version_code')->textInput(['maxlength' => true]) ?> 
    <?= $form->field($model, 'force')->dropDownList([0=>'不强更',1=>'强更']);?>
    <?= $form->field($model, 'pay_method')->dropDownList([0=>'默认',1=>'爱贝支付']);?>
    <?= $form->field($model, 'ipay')->dropDownList(CfgIpayParams::getIappayDropList());?>
    <?= $form->field($model, 'inreviewstat')->dropDownList([0=>'不审核',1=>'在审核，开启IPV6关闭典当赠送']);?> 
    <?= $form->field($model, 'inreviewbuild')->textInput(['maxlength' => true]) ?>  
    
    <?= $form->field($model, 'ctime')->textInput(['readonly'=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
