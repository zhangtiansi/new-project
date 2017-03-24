<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CfgProducts;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\GmOrderlistSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gm-orderlist-search">

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
    <?= $form->field($model, 'playerid',['options'=>['class'=>'form-group-cus'],'inputOptions'=>['class'=>'form-cus']]) ?>
    
    <?= $form->field($model, 'productid',['options'=>['class'=>'form-group-cus'],'inputOptions'=>['class'=>'form-cus']])
        ->dropDownList(array_merge([0=>"不限"],ArrayHelper::map(CfgProducts::getProductList(), 'id', 'product_id')));?>
    <?= $form->field($model, 'source',['options'=>['class'=>'form-group-cus'],'inputOptions'=>['class'=>'form-cus']]) ?>
    <?= $form->field($model, 'status',['options'=>['class'=>'form-group-cus'],'inputOptions'=>['class'=>'form-cus']])->dropDownList([0=>'待支付',1=>'待处理',2=>"已支付"],['selected'=>'2']);?>
<?= $form->field($model, 'orderid',['options'=>['class'=>'form-group-cus'],'inputOptions'=>['class'=>'form-cus']]) ?>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
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