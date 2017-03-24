<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GmAccountInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="first-order">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php 
    $tpl='<div class="col-sm-5">{label}<span class="input-group-addon">{input}<i class="icon-calendar"></i></span>{error}{hint}</div>';
    ?>
    <div>
    <?= $form->field($model, 'starttm',['template'=>$tpl, 'options'=>['class'=>'form-group-cus'],'inputOptions'=>['id'=>'idstart_tm']]) ?>
    <?= $form->field($model, 'endtm',['template'=>$tpl,'options'=>['class'=>'form-group-cus'],'inputOptions'=>['id'=>'idend_tm']]) ?>
    </div>
    <?= $form->field($model, 'gid') ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'payType') ?>
    <?= $form->field($model, 'fee') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
.form-group-cus {
    margin-bottom: 10px;
    max-width: 300px;
    display: -webkit-inline-box;
}
.form-cus{
    width: 100px;
    max-width: 100px;
 }   
</style>