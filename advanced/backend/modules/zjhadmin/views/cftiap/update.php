<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CfgIpayParams */

$this->title = 'Update Cfg Ipay Params: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cfg Ipay Params', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cfg-ipay-params-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
