<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CfgProps;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\LogGiftSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-gift-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'from_uid') ?>

    <?= $form->field($model, 'to_uid') ?>

    <?= $form->field($model, 'gift_id')->dropDownList(array_merge([0=>"不限"],ArrayHelper::map(CfgProps::getGiftList(), 'id', 'prop_name')));?>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
