<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CfgVipCard */

$this->title = 'Update Cfg Vip Card: ' . ' ' . $model->card_id;
$this->params['breadcrumbs'][] = ['label' => 'Cfg Vip Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->card_id, 'url' => ['view', 'id' => $model->card_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cfg-vip-card-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
