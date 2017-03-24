<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\CfgCoinChangetype;

/* @var $this yii\web\View */
/* @var $model app\models\DataDailyCoinchangeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-daily-coinchange-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'udate') ?>

    <?= $form->field($model, 'change_type')->dropDownList(array_merge([0=>"不限"],ArrayHelper::map(CfgCoinChangetype::getTypeList(), 'cid', 'c_name')));?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
