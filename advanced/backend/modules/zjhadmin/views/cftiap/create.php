<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgIpayParams */

$this->title = 'Create Cfg Ipay Params';
$this->params['breadcrumbs'][] = ['label' => 'Cfg Ipay Params', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-ipay-params-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
