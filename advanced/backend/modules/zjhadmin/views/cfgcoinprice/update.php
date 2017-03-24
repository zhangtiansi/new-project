<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CfgCoinPrice */

$this->title = 'Update Cfg Coin Price: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cfg Coin Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cfg-coin-price-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
