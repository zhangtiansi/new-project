<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
 
/* @var $this yii\web\View */
/* @var $model app\models\GmAccountInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="toprecharge">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'win_uid') ?>  
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?> 
    </div>

    <?php ActiveForm::end(); ?>

</div>
