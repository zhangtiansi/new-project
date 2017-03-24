<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CfgWarconfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cfg-warconfig-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'di_coin')->textInput() ?>

    <?= $form->field($model, 'shang_coin')->textInput() ?>

    <?= $form->field($model, 'xia_coin')->textInput() ?>

    <?= $form->field($model, 'seat_coin')->textInput() ?>

    <?= $form->field($model, 'xia_turn')->textInput() ?>

    <?= $form->field($model, 'ya_shui')->textInput() ?>

    <?= $form->field($model, 'war_id')->textInput() ?>

    <?= $form->field($model, 'stime')->textInput() ?>

    <?= $form->field($model, 'robot_coin')->textInput() ?>

    <?= $form->field($model, 'war_open')->textInput() ?>

    <?= $form->field($model, 'max_coin')->textInput() ?>

    <?= $form->field($model, 'seat_coin_min')->textInput() ?>

    <?= $form->field($model, 'prize_shui')->textInput() ?>

    <?= $form->field($model, 'prize_coin')->textInput() ?>

    <?= $form->field($model, 'prize_coin_max')->textInput() ?>

    <?= $form->field($model, 'prize_name_max')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'card_1')->textInput() ?>

    <?= $form->field($model, 'card_2')->textInput() ?>

    <?= $form->field($model, 'card_3')->textInput() ?>

    <?= $form->field($model, 'card_type_1')->textInput() ?>

    <?= $form->field($model, 'card_type_2')->textInput() ?>

    <?= $form->field($model, 'card_type_3')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
