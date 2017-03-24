<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GmMonthCard */

$this->title = '添加月卡';
$this->params['breadcrumbs'][] = ['label' => '月卡', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-month-card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
