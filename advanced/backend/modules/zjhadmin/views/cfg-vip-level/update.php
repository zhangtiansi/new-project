<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CfgVipLevel */

$this->title = 'Update Cfg Vip Level: ' . ' ' . $model->vip_level;
$this->params['breadcrumbs'][] = ['label' => 'Cfg Vip Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vip_level, 'url' => ['view', 'id' => $model->vip_level]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cfg-vip-level-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
