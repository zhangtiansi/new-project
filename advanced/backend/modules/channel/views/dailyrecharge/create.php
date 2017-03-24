<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DataDailyRecharge */

$this->title = 'Create Data Daily Recharge';
$this->params['breadcrumbs'][] = ['label' => 'Data Daily Recharges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-daily-recharge-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
