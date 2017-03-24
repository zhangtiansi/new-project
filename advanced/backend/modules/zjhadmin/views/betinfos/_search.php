<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\LogBetResults;

/* @var $this yii\web\View */
/* @var $model app\models\GmAccountInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="betinfos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gid') ?>

    <?php echo $form->field($model, 'bid') ?>
    <?= $form->field($model, 'bettype')->dropDownList(array_merge([0=>"不限"],LogBetResults::$px));?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
