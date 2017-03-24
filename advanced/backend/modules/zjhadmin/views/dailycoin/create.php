<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DataDailyCoinchange */

$this->title = 'Create Data Daily Coinchange';
$this->params['breadcrumbs'][] = ['label' => 'Data Daily Coinchanges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-daily-coinchange-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
