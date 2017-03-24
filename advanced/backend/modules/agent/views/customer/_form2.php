<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\AgentInfo;
use yii\helpers\ArrayHelper;
use app\models\CfgProps;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $model app\models\LogCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-customer-form">
<?php $agent=AgentInfo::findOne(['account_id'=>Yii::$app->user->id]);
    $money=is_object($agent)?$agent->money:"0";
    $tpl='{label} <div class="row"><div class="col-sm-11">{input}{error}{hint}</div></div>';
?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gid', [
    'template' => $tpl
    ])->textInput()->label('输入玩家ID' ) ?>
 

    <?=  $form->field($model, 'coin', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('RMB100元=800万'),
        ],
    'template' => $tpl
    ])->textInput()->label('充值RMB元(RMB1元=8万),您的余额 '.$money) ;?>
    
    <?= $form->field($model, 'desc', [
    'template' => $tpl
    ])->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'point', [
    'template' => $tpl
    ])->textInput() ?>
    <?= $form->field($model, 'propid', [
    'template' => $tpl
    ])->dropDownList(array_merge([0=>'无'],ArrayHelper::map(CfgProps::getgiftPropList(), 'id', 'prop_name'))) ?>

    <?= $form->field($model, 'propnum', [
    'template' => $tpl
    ])->textInput() ?>

    <?= $form->field($model, 'card_g', [
    'template' => $tpl
    ])->textInput() ?>

    <?= $form->field($model, 'card_s', [
    'template' => $tpl
    ])->textInput() ?>

    <?= $form->field($model, 'card_c', [
    'template' => $tpl
    ])->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '充值' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
