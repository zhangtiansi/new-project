<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CfgCoinChangetype;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\LogCoinRecordsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-coin-records-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'uid') ?> 

    <?php  echo $form->field($model, 'game_no') ?>
    <?php  echo $form->field($model, 'change_coin') ?>
    <?php  echo $form->field($model, 'prop_id') ?>
    <?php echo $form->field($model, 'bg_tm') ?>
    <?php echo $form->field($model, 'end_tm') ?>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
