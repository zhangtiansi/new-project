<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GmChannelInfo */

$this->title = '更新渠道信息 ' . ' ' . $model->cid;
$this->params['breadcrumbs'][] = ['label' => 'Gm Channel Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cid, 'url' => ['view', 'id' => $model->cid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gm-channel-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelacc'=>$modelacc,
    ]) ?>

</div>
