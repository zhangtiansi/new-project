<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DataMonthRecharge */

$this->title = 'Create Data Month Recharge';
$this->params['breadcrumbs'][] = ['label' => 'Data Month Recharges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-month-recharge-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
