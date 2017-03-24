<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgCoinPrice */

$this->title = 'Create Cfg Coin Price';
$this->params['breadcrumbs'][] = ['label' => 'Cfg Coin Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-coin-price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
