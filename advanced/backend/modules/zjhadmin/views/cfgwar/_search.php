<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgWarconfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-warconfig-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'di_coin') ?>

    <?= $form->field($model, 'shang_coin') ?>

    <?= $form->field($model, 'xia_coin') ?>

    <?= $form->field($model, 'seat_coin') ?>

    <?php // echo $form->field($model, 'xia_turn') ?>

    <?php // echo $form->field($model, 'ya_shui') ?>

    <?php // echo $form->field($model, 'war_id') ?>

    <?php // echo $form->field($model, 'stime') ?>

    <?php // echo $form->field($model, 'robot_coin') ?>

    <?php // echo $form->field($model, 'war_open') ?>

    <?php // echo $form->field($model, 'max_coin') ?>

    <?php // echo $form->field($model, 'seat_coin_min') ?>

    <?php // echo $form->field($model, 'prize_shui') ?>

    <?php // echo $form->field($model, 'prize_coin') ?>

    <?php // echo $form->field($model, 'prize_coin_max') ?>

    <?php // echo $form->field($model, 'prize_name_max') ?>

    <?php // echo $form->field($model, 'card_1') ?>

    <?php // echo $form->field($model, 'card_2') ?>

    <?php // echo $form->field($model, 'card_3') ?>

    <?php // echo $form->field($model, 'card_type_1') ?>

    <?php // echo $form->field($model, 'card_type_2') ?>

    <?php // echo $form->field($model, 'card_type_3') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
