<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CfgWarPlayerBanker */

$this->title = 'Update Cfg War Player Banker: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '百人万家庄配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cfg-war-player-banker-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>5个概率总和为概率基数</p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
