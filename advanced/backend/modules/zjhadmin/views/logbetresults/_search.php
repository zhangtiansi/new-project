<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\LogBetResults;

/* @var $this yii\web\View */
/* @var $model app\models\LogBetResultsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-bet-results-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bid') ?>

    <?= $form->field($model, 'result')->dropDownList(array_merge([0=>"不限"],LogBetResults::$px));?>
    
    
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
