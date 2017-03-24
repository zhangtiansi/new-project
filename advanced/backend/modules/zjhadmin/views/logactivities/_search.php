<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\GmOptact;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\LogActivitiesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-activities-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'uid') ?>
    <?= $form->field($model, 'actid')->dropDownList(array_merge([0=>"不限"],ArrayHelper::map(GmOptact::getOptactList(), 'id', 'act_title')));?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
